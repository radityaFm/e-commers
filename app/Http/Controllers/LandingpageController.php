<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landingpage');
    }
    protected function authenticated(Request $request, $user)
{
    return redirect()->route('landingpage');
}

    public function admin()
    {
        return redirect()->route('admin');
    }
}