<?php

namespace App\Http\Controllers;

use App\Models\Warung;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Display a listing of the ulasan (reviews) for a specific warung.
     *
     * @param  int  $warung_id
     * @return \Illuminate\View\View
     */
    public function index($warung_id)
{
    $warung = Warung::findOrFail($warung_id);
    $ulasan = $warung->ulasan;
    $hasReviewed = $this->hasUserReviewed($warung_id);

    return view('warung.ulasan', compact('warung', 'ulasan', 'hasReviewed'));
}
    public function store(Request $request, $warung_id)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        // Pastikan warung_id valid
        $warung = Warung::findOrFail($warung_id);

        // Simpan ulasan
        Ulasan::create([
            'user_id' => Auth::id(),
            'warung_id' => $warung->warung_id,
            'rating' => $request->input('rating'),
            'komentar' => $request->input('komentar'),
        ]);

        // Redirect ke halaman lihat ulasan dengan pesan sukses
        return redirect()->route('ulasan.lihatUlasan', $warung_id)
            ->with('success', 'Ulasan berhasil dikirim.');
    }
    public function lihatUlasan($warung_id)
    {
        // Ambil data warung beserta ulasan terkait
        $warung = Warung::with('ulasan.user')->findOrFail($warung_id);

        // Kirim data ke view
        return view('warung.lihatUlasan', compact('warung'));
    }

    public function hapus($warung_id, $ulasan_id)
    {
        $ulasan = Ulasan::findOrFail($ulasan_id);

        if (Auth::user()->hasRole('Admin')) {
            $ulasan->delete();
            return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
        }

        if (Auth::id() === $ulasan->user_id) {
            $ulasan->delete();
            return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus ulasan ini.');
    }

    public function hasUserReviewed($warung_id)
{
    return Ulasan::where('warung_id', $warung_id)
        ->where('user_id', Auth::id())
        ->exists();
}
}
