<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login? Kalau belum, tendang ke halaman login.
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah 'role' user yang login cocok dengan role yang diizinkan?
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request); // Silakan lewat!
        }

        // 3. Kalau role-nya tidak cocok (misal Pegawai maksa masuk ke area Admin)
        abort(403, 'AKSES DITOLAK! Halaman ini hanya untuk Admin.');
    }
}