<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
    
    $request->validate([
        'name' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
    ]);

    $user = auth()->user();
    $user->name = $request->name;

    // Handle upload foto
    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Simpan foto baru ke folder 'userPhotos'
        $path = $request->file('photo')->store('userPhotos', 'public');
        $user->photo = $path;
    }

    $user->save();

    return redirect()->route('account.profile')->with('success', 'Profile updated successfully!');
}

public function updateProfile(Request $request)
{
    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $user = Auth::user();

    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($user->photo) {
            Storage::delete('public/' . $user->photo);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('userPhotos', 'public');
        $user->photo = $path;
    }

    $user->save();

    return redirect()->route('account.editprofile')->with('success', 'Profile updated successfully.');
}

    public function deleteAccount() {
        $user = Auth::user();
        $user->delete();

        return redirect()->route('login')->with('success', 'Akun Anda telah dihapus.');
    }
}
