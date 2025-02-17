<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
     public function handle(Request $request, Closure $next)
     {
         // Cek apakah pengguna sudah login dan memiliki role 'user'
         if (Auth::check() && Auth::user()->role === 'user') {
             return $next($request);
         }
 
         // Jika bukan user, redirect ke halaman admin atau tampilkan error
         return redirect()->route('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
     }
}
