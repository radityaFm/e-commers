<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('account.editprofile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
    
        // Validasi nama dan email, email tetap tidak bisa diubah
        $validated = $request->validate([
            'name' => 'required|string|max:15',
        ], [
            'name.max' => 'The name should not exceed 15 characters.',
        ]);
    
        // Update nama
        $user->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('account.profile')->with('success', 'Profile updated successfully');
    }    


    public function updatePhoto(Request $request) {
        $user = Auth::user();

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('public/profile', $filename);

        $user->update(['photo' => $filename]);

        return redirect()->route('account.profile')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request) {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account.profile')->with('success', 'Password berhasil diperbarui.');
    }

    public function deleteAccount() {
        $user = Auth::user();
        $user->delete();

        return redirect()->route('auth.login')->with('success', 'Akun Anda telah dihapus.');
    }
}
