<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetRolePrefix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user) {
            $expectedRole = $user->role === 'admin_ranting' ? 'admin-ranting' : $user->role;
            $urlRole = $request->route('role');

            // Jika URL role tidak sesuai dengan role user, redirect ke URL yang benar
            if ($urlRole !== null && $urlRole !== $expectedRole) {
                // Jangan loop jika tidak punya role (misalnya jika error 404 tapi masuk sini)
                if (in_array($urlRole, ['superadmin', 'admin-ranting'])) {
                    // Ganti segmen role di URL
                    $newUrl = str_replace("/{$urlRole}", "/{$expectedRole}", $request->fullUrl());
                    return redirect()->to($newUrl);
                } else {
                    abort(403, 'Akses tidak sah.');
                }
            }

            // Set parameter {role} secara otomatis untuk fungsi route()
            URL::defaults(['role' => $expectedRole]);
            
            // Hapus parameter role agar controller tidak perlu menerimanya di argumen method
            $request->route()->forgetParameter('role');
        }

        return $next($request);
    }
}
