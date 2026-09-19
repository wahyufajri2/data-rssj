<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user) {
            // Jika belum verifikasi email, redirect ke halaman verifikasi
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            // Jika sudah verifikasi tapi belum aktif
            if (!$user->is_active) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda telah diverifikasi, namun sedang menunggu persetujuan Superadmin.'
                ]);
            }
        }

        return $next($request);
    }
}
