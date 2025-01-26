<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:5', // Minimal 5 karakter untuk password
        ]);

        // Cek kredensial login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerasi session untuk menghindari session fixation
            $request->session()->regenerate();

            // Redirect ke landing page setelah login berhasil
            return redirect()->route('landingpage');
        } else {
            // Debugging: Cek data yang dikirimkan saat login gagal
            return redirect()->route('landingpage');

            // Jika login gagal, kembalikan dengan pesan error
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Menangani proses registrasi
    public function register(Request $request)
    {
        // Validasi input registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5|confirmed', // Minimal 5 karakter dan konfirmasi password
        ]);

        // Cek apakah password dan password konfirmasi cocok
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors([
                'password' => 'Password tidak sama.',
            ]);
        }

        // Cek apakah email sudah terdaftar
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->route('auth.login')->with('info', 'Email sudah terdaftar. Silakan login.');
        }

        // Simpan data pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Redirect ke form login setelah registrasi sukses
        return redirect()->route('auth.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Menangani logout
    public function logout(Request $request)
    {
        // Proses logout
        Auth::logout();

        // Hapus semua session dan buat token baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect()->route('auth.login');
    }
}
