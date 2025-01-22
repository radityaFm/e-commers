<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Jika pengguna sudah login, arahkan ke halaman keranjang pesanan
            return redirect()->route('order.index');
        }

        // Tampilkan landing page jika pengguna belum login
        return view('landingpage');
    }
}