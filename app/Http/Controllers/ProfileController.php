<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan profil pengguna
    public function index()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login
        return view('account.profile', compact('user')); // Mengirimkan data pengguna ke view
    }

    // Mengupdate username pengguna
    public function updateUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->username = $request->username;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Username berhasil diperbarui.');
    }

    // Mengupdate password pengguna
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Mengecek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('account.profile')->with('error', 'Password lama tidak sesuai.');
        }

        // Mengupdate password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Password berhasil diperbarui.');
    }

    // Mengupdate foto profil pengguna
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        $user = Auth::user();

        // Menghapus foto lama jika ada
        if ($user->photo) {
            Storage::delete('public/profile/' . $user->photo);
        }

        // Menyimpan foto baru
        $photo = $request->file('photo')->store('profile', 'public');
        $user->photo = basename($photo); // Menyimpan nama file foto
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Foto profil berhasil diperbarui.');
    }

    // Menghapus akun pengguna
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Menghapus foto profil jika ada
        if ($user->photo) {
            Storage::delete('public/profile/' . $user->photo);
        }

        // Menghapus pengguna
        $user->delete();

        // Logout setelah menghapus akun
        Auth::logout();

        return redirect()->route('landingpage')->with('success', 'Akun berhasil dihapus.');
    }
}
