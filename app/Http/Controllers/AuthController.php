<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:3',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'Maaf, Anda belum register.')->withInput();
        }
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Cek jika login dari Filament (admin panel)
            if ($request->is('admin/*') || $request->is('admin')) {
                if ($user->role !== 'admin') {
                    Auth::logout();
                    return redirect()->route('auth.login')->with('error', 'Anda tidak memiliki akses admin.')->withInput();
                }
    
                return redirect()->route('admin')->with('success', 'Login berhasil! Selamat datang Admin');
            }
    
            // Redirect berdasarkan role
            if ($user->role === 'user') {
                return redirect()->route('/')->with('success', 'Login berhasil! Selamat datang');
            } else {
                return redirect()->route('/')->with('success', 'Login berhasil! Selamat datang Admin');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email atau password salah.')->withInput();
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

        // Simpan data pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role adalah user
        ]);

        // Redirect ke form login setelah registrasi sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
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
        return redirect()->route('/');
    }
}