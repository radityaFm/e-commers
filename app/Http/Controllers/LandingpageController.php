<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Jika pengguna sudah login, arahkan ke halaman landing page
            return view('landingpage');
        }

        // Jika pengguna belum login, arahkan ke halaman login
        return redirect()->route('auth.login');
    }
}