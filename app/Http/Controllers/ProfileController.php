<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = $request->user();
    
    if ($request->email !== $user->email || !Auth::validate(['email' => $user->email, 'password' => $request->password])) {
        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->withInput();
    }

    Auth::logout();
    $user->delete();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/foodexplore');

}


   

    public function updateFoto(Request $request)
    {
        $request->validate([
            'photo_profile' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
    
        $user = $request->user();
    
        if ($request->hasFile('photo_profile')) {
            // Delete old photo if exists
            if ($user->photo_profile && file_exists(public_path($user->photo_profile))) {
                unlink(public_path($user->photo_profile));
            }
    
            // Save new photo
            $image = $request->file('photo_profile');
            $photoName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $photoName);
            
            // Update database
            $user->photo_profile = 'img/' . $photoName;
            $user->save();
        }
    
        return redirect()->route('profile.edit')->with('status', 'Foto profil berhasil diperbarui!');
    }


}
