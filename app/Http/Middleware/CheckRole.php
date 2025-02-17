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
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login dan memiliki role yang sesuai
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect('/'); // atau sesuaikan dengan redireksi yang diinginkan
        }

        return $next($request);
    }
}