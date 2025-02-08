<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ManageAccountController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('manageAccount.listAccount', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Ambil semua role yang tersedia
        return view('manageAccount.createAccount', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',  // Make sure it's confirmed
            'role' => 'required',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi untuk foto profil
        ]);
        

        // Proses upload foto profil jika ada
        $photoProfileName = null;
        if ($request->hasFile('photo_profile')) {
            $image = $request->file('photo_profile');
            $photoProfileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $photoProfileName);
            $photoProfileName = 'img/' . $photoProfileName;
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo_profile' => $photoProfileName, // Simpan foto profil
        ]);

        // Assign role ke user
        $user->assignRole($request->role);

        // Redirect ke halaman list account dengan pesan sukses
        return redirect()->route('manageAccount.index')
            ->with('success', 'User created successfully');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        
        return redirect()->route('manageAccount.index')
            ->with('success', 'User deleted successfully');
    }
}
