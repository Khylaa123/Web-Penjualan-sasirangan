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
        $userRole = strtolower((string) Auth::user()->role);
        $allowedRoles = array_map(fn ($role) => strtolower(trim($role)), $roles);

        // Role tidak sesuai
if (Auth::user()->role === 'Pembeli') {
    return redirect()->route('home')
        ->with('error', 'Silakan login sebagai Admin atau Pegawai.');
}

abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    
    }
}