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

    public function admin()
    {
        return redirect()->route('filament.admin.panel');
    }
}