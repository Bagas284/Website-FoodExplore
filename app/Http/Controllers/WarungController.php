<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Warung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WarungController extends Controller
{
    public function index()
    {
        // Ambil semua warung untuk Admin dan User
        $warung = Warung::all();

        // Jika role adalah Warung, hanya tampilkan warung milik mereka
        if (Auth::user()->hasRole('Warung')) {
            $warung = Warung::where('user_id', Auth::id())->get();
        }

        return view('warung', compact('warung'));
    }

    public function destroy($id)
    {
        $warung = Warung::findOrFail($id);

        // Cek apakah warung memiliki gambar
        if ($warung->image && file_exists(public_path('img/' . $warung->image))) {
            // Hapus gambar dari folder public/img
            unlink(public_path('img/' . $warung->image));
        }

        // Hapus data terkait di tabel menu
        Menu::where('warung_id', $id)->delete();

        // Hapus data warung
        $warung->delete();

        return redirect()->route('warung.index')->with('success', 'Warung berhasil dihapus.');
    }



    public function store(Request $request)
    {
        // Cek jika pengguna yang sedang login sudah memiliki warung
        if (Auth::user()->hasRole('Warung') && Warung::where('user_id', Auth::id())->exists()) {
            return redirect()->route('warung.index')->with('error', 'Anda hanya dapat menambahkan satu warung.');
        }

        $request->validate([
            'nama_warung' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_wa' => 'required|string|max:15',
            'image' => 'nullable|image',
            'status_pengantaran' => 'required|in:aktif,tidak aktif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $warung = new Warung();
        $warung->nama_warung = $request->input('nama_warung');
        $warung->slug = Str::slug($request->input('nama_warung'));
        $warung->alamat = $request->input('alamat');
        $warung->no_wa = $request->input('no_wa');
        $warung->status_pengantaran = 'aktif';
        $warung->latitude = $request->input('latitude');  
        $warung->longitude = $request->input('longitude');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
            $warung->image = $imageName;
        }

        $warung->user_id = Auth::id();
        $warung->save();

        // Redirect ke tampilan warung
        return redirect()->route('warung.index')->with('success', 'Warung berhasil ditambahkan!');
    }




    public function search(Request $request)
    {
        $query = $request->input('search_query');

        // Ambil semua warung berdasarkan role
        $warung = Warung::query();

        if (Auth::user()->hasRole('Warung')) {
            $warung->where('user_id', Auth::id());
        }

        // Filter warung berdasarkan query
        if ($query) {
            $warung->where('nama_warung', 'LIKE', "%{$query}%");
        }

        $warung = $warung->get();

        return view('warung', compact('warung'));
    }


    public function showMenu($id)
    {
        $warung = Warung::with('menu')->findOrFail($id);
        return view('warung.menu', compact('warung'));
    }

    public function addMenu($id)
    {
        $warung = Warung::findOrFail($id);
        return view('warung.add_menu', compact('warung'));
    }

    public function storeMenu(Request $request, $id)
    {
        $warung = Warung::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'ketersediaan' => 'nullable|in:tersedia,habis',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }

        $warung->menu()->create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'ketersediaan' => $request->ketersediaan ?? 'tersedia',
            'image' => $imagePath,
        ]);

        return redirect()->route('warung.showMenu', $warung->warung_id)->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $warung = Warung::findOrFail($id);
        return view('warung.editWarung', compact('warung'));
    }

    // Method untuk mengupdate data warung
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_wa' => 'required|string|max:15',
            'status_pengantaran' => 'required|in:aktif,tidak aktif',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'required|numeric',  
            'longitude' => 'required|numeric', 
        ]);

        $warung = Warung::findOrFail($id);
        $warung->nama_warung = $request->nama_warung;
        $warung->alamat = $request->alamat;
        $warung->no_wa = $request->no_wa;
        $warung->status_pengantaran = $request->status_pengantaran;
        $warung->latitude = $request->latitude;   
        $warung->longitude = $request->longitude;

        // Cek apakah gambar diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($warung->image && file_exists(public_path('img/' . $warung->image))) {
                unlink(public_path('img/' . $warung->image));
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
            $warung->image = $imageName;
        }

        $warung->save();

        return redirect()->route('warung.index')->with('success', 'Warung berhasil diperbarui!');
    }

    public function getLocation($id)
    {
        $warung = Warung::findOrFail($id);
        return response()->json([
            'latitude' => $warung->latitude,
            'longitude' => $warung->longitude
        ]);
    }

    // Tambah method untuk update lokasi
    public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $warung = Warung::findOrFail($id);
        $warung->latitude = $request->latitude;
        $warung->longitude = $request->longitude;
        $warung->save();

        return response()->json(['message' => 'Lokasi berhasil diperbarui']);
    }
}
