<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('auth.login'); // atau halaman lain jika perlu
        }

        $user = Auth::user();

        // Periksa apakah user memiliki salah satu role yang diberikan
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request); // Jika memiliki role yang sesuai, lanjutkan request
            }
        }

        // Jika user tidak memiliki role yang sesuai, redirect ke halaman tertentu dengan pesan error
        return redirect()->route('landingpage')->with('error', 'Sorry, kamu tidak memiliki akses ke halaman ini!');
    }
}
