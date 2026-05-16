<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    // ==========================================
    // 1. FITUR LOGIN
    // ==========================================

    /**
     * Menampilkan form login
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('pages.auth.login', [
            'title' => 'Login EMBRACE',
        ]);
    }

    /**
     * Proses login
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'no_hp' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'no_hp' => 'Nomor HP atau Password salah.',
        ])->withInput($request->only('no_hp'));
    }

    // ==========================================
    // 2. FITUR REGISTRASI (SEAMLESS ONBOARDING)
    // ==========================================

    /**
     * Menampilkan form registrasi pasien baru.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('pages.auth.register', [
            'title' => 'Daftar Akun EMBRACE',
        ]);
    }

    /**
     * Memproses pendaftaran pasien baru (Bebas Hambatan)
     */
    public function registerUser(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'no_hp'    => ['required', 'string', 'max:20', 'unique:users,no_hp'],
            'email'    => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'no_hp.unique' => 'Nomor HP ini sudah terdaftar. Silakan masuk atau gunakan nomor lain.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Simpan user baru ke database
        $user = User::create([
            'name'     => $request->name,
            'no_hp'    => $request->no_hp,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'patient',
        ]);

        // 3. SEAMLESS ONBOARDING: Langsung login-kan user
        Auth::login($user);

        // 4. Regenerasi session untuk keamanan (Sangat Penting)
        $request->session()->regenerate();

        // 5. Arahkan langsung ke halaman skrining kecemasan
        return redirect()->route('pasien.skrining-awal')->with('status', 'Pendaftaran berhasil! Selamat datang di aplikasi EMBRACE.');
    }

    // ==========================================
    // 3. FITUR LUPA PASSWORD (OTP VIA NO_HP)
    // ==========================================

    /**
     * Tampilkan Form Lupa Password (Input Nomor HP)
     */
    public function showForgotForm(): View
    {
        return view('pages.auth.forgot-password', [
            'title' => 'Lupa Password',
        ]);
    }

    /**
     * Generate dan Kirim OTP ke WhatsApp/SMS
     */
    public function sendResetOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'no_hp' => ['required', 'exists:users,no_hp'],
        ], [
            'no_hp.exists' => 'Nomor HP ini belum terdaftar di sistem kami.',
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['no_hp' => $request->no_hp],
            [
                'token' => Hash::make($otp),
                'created_at' => Carbon::now()
            ]
        );

        // TODO: Panggil API WhatsApp (Fonnte/Watzap) di sini
        \Illuminate\Support\Facades\Log::info("OTP Lupa Password untuk {$request->no_hp} : {$otp}");

        return redirect()->route('password.reset.form')->with([
            'status' => 'Kode OTP telah dikirim ke WhatsApp/SMS Anda.',
            'no_hp' => $request->no_hp
        ]);
    }

    /**
     * Tampilkan Form Input OTP dan Password Baru
     */
    public function showResetForm(Request $request): View
    {
        return view('pages.auth.reset-password', [
            'title' => 'Verifikasi OTP & Reset Password',
            'no_hp' => $request->session()->get('no_hp'),
        ]);
    }

    /**
     * Validasi OTP dan Simpan Password Baru
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'no_hp' => ['required', 'exists:users,no_hp'],
            'otp' => ['required', 'numeric', 'digits:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('no_hp', $request->no_hp)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['otp' => 'Sesi reset password tidak ditemukan. Silakan minta OTP baru.']);
        }

        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('no_hp', $request->no_hp)->delete();
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        if (!Hash::check($request->otp, $resetRecord->token)) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.']);
        }

        $user = User::where('no_hp', $request->no_hp)->first();
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));
        $user->save();

        DB::table('password_reset_tokens')->where('no_hp', $request->no_hp)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan masuk menggunakan password baru.');
    }

    // ==========================================
    // 4. FITUR LOGOUT & REDIRECT HELPER
    // ==========================================

    /**
     * Proses Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Helper untuk menentukan rute redirect berdasarkan role
     */
    protected function redirectBasedOnRole(): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'patient') {
            return redirect()->route('pasien.skrining-awal');
        }

        Auth::logout();
        return redirect()->route('login')->withErrors(['no_hp' => 'Akun tidak memiliki akses yang valid.']);
    }
}
