<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('pages.auth.login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request, AuthService $authService): RedirectResponse
    {
        $result = $authService->login(
            $request->username,
            $request->password,
            $request->boolean('remember')
        );

        if (!$result['success']) {
            return back()->withErrors([
                'username' => 'Username atau Password salah.',
            ])->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        return $this->redirectBasedOnRole();
    }

    /**
     * Tampilkan Form Lupa Password
     */
    public function showForgotForm(): View
    {
        return view('pages.auth.forgot-password', [
            'title' => 'Lupa Password',
        ]);
    }

    /**
     * Kirim Link Reset Password ke Email
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'email' => [
                'required', 
                'email', 
                'exists:users,email' // <--- INI KUNCINYA
            ],
        ], [
            // Custom pesan error jika email tidak ada
            'email.exists' => 'Email ini belum terdaftar di sistem kami.',
        ]);

        // 2. Kirim link menggunakan Password Broker Laravel
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // 3. Cek hasil pengiriman
        if ($status === Password::RESET_LINK_SENT) {
            // Menggunakan back() agar tetap di halaman forgot password, bukan ke login
            return back()->with('status', __($status));
        }

        // Jika gagal kirim
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    /**
     * Tampilkan Form Reset Password
     */
    public function showResetForm(Request $request, $token = null): View
    {
        return view('pages.auth.reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Proses Reset Password Baru
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        // 1. Validasi Input Password Baru
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Proses Reset
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // 3. Redirect jika sukses
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika gagal (Token expired atau email salah)
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    /**
     * Logout
     */
    public function destroy(): RedirectResponse
    {
        Auth::guard('web')->logout(); // Logout guard web default

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect berdasarkan peran
     */
    protected function redirectBasedOnRole(): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $roleEnum = Role::fromId((int) $user->peran_id); 

        if (!$roleEnum) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['username' => 'Akun tidak memiliki peran yang valid.']);
        }

        return redirect()->route($roleEnum->dashboardRoute());
    }
}