<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
        // 1. Belum login
        if (!Auth::check()) {
            return redirect()->route('login')->with('toast', [
                'type' => 'error',
                'message' => 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.',
            ]);
        }

        $user = Auth::user();

        // 2. Ambil role dari Enum
        $roleEnum = Role::fromId((int) $user->peran_id);

        // 3. Role tidak valid → logout paksa
        if (!$roleEnum) {
            Auth::logout();

            $toast = [
                'type' => 'error',
                'message' => 'Terjadi kesalahan pada akun Anda. Silakan login kembali.',
            ];

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session()->flash('toast', $toast);

            return redirect()->route('login');
        }

        // 4. Role tidak sesuai → fallback redirect
        if ($roleEnum->key() !== $requiredRole) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman tersebut.',
            ]);

            return redirect()->route($roleEnum->dashboardRoute());
        }

        return $next($request);
    }
}
