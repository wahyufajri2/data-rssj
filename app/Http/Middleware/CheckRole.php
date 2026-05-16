<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
        // 1. Jika belum login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')->with('toast', [
                'type' => 'error',
                'message' => 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.',
            ]);
        }

        $user = Auth::user();

        // 2. Jika role yang login TIDAK SAMA dengan role yang diizinkan di route
        if ($user->role !== $requiredRole) {

            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman tersebut.',
            ]);

            // 3. Fallback: Arahkan kembali ke dashboard masing-masing sesuai role aslinya
            if ($user->role === 'admin') {
                // Pastikan route 'admin.dashboard' ada di web.php
                return redirect()->route('admin.dashboard');
            }

            // Default fallback untuk pasien
            // Pastikan route 'screening' ada di web.php
            return redirect()->route('screening');
        }

        // 4. Jika role sesuai, izinkan akses berlanjut
        return $next($request);
    }
}
