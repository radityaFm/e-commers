<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }
    

    // Update Username
    public function updateUsername(Request $request)
    {
        $request->validate(['username' => 'required|string|max:255|unique:users,username,' . Auth::id()]);
        $user = Auth::user();
        $user->username = $request->username;
        $user->save();

        return back()->with('success', 'Username berhasil diperbarui.');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    // Update Foto Profil
    public function updatePhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,png,jpeg|max:2048']);

        $user = Auth::user();
        if ($user->photo) {
            Storage::delete('public/profile/' . $user->photo);
        }

        $fileName = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('public/profile', $fileName);

        $user->photo = $fileName;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    // Hapus Akun Secara Permanen
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if ($user->photo) {
            Storage::delete('public/profile/' . $user->photo);
        }

        $user->forceDelete();
        Auth::logout();

        return redirect('auth.register')->with('success', 'Akun Anda telah dihapus secara permanen.');
    }
}
