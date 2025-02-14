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
         if (!Auth::check()) {
             return redirect()->route('auth.login'); // Redirect ke login jika belum login
         }
     
         // Contoh: Hanya user dengan role 'user' yang bisa lanjut
         if (Auth::user()->role !== 'user') {
             return redirect()->route('landingpage'); // Redirect ke landing page jika role tidak sesuai
         }
     
         return $next($request);
     }
}
