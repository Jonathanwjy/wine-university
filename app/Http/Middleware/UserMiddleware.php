<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Periksa apakah role pengguna adalah Admin (role 0)
            if (Auth::user()->role == 'user') {
                // Jika ya, lanjutkan ke request berikutnya
                return $next($request);
            } else {
                return response()->view('403error', [], 403);
            }
        } else {
            // Jika belum login, logout dan arahkan ke halaman login
            return redirect()->route('login');
        }
    }
}
