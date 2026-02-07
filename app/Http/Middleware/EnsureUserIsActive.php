<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login, lempar ke login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Logika User Pending
        if (Auth::user()->role == 'user' && Auth::user()->status == 'pending' || Auth::user()->status == 'inactive') {
            // Cek agar tidak redirect loop (berulang-ulang)
            if (!$request->routeIs('account.pending') && !$request->routeIs('logout')) {
                return redirect()->route('account.pending');
            }
        }

        // --- PASTIKAN BARIS INI ADA DAN TERJANGKAU ---
        return $next($request);
    }
}
