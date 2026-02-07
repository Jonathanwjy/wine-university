<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
            if (Auth::user()->role == 'admin') {
                // Jika ya, lanjutkan ke request berikutnya
                return $next($request);
            } else {
                return response()->view('403', [], 403);
            }
        } else {
            // Jika belum login, logout dan arahkan ke halaman login
            return redirect()->route('login');
        }
    }
}
