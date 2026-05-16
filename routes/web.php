<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GadQuestionController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ScreeningController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DukunganController;
use App\Http\Controllers\Patient\InitialScreeningController;
use App\Http\Controllers\Patient\InterventionController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rute Root (Cerdas)
Route::get('/', function () {
    // Jika user sudah login
    if (Auth::check()) {
        $user = Auth::user();

        /** @var \App\Models\User $user */
        // Arahkan ke dashboard masing-masing sesuai role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('patient')) {
            return redirect()->route('pasien.dashboard');
        }

        // JIKA TIDAK PUNYA ROLE (Akun bermasalah / belum di-set rolenya)
        // Paksa keluar (logout) dan kembalikan ke halaman login dengan pesan error
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'no_hp' => 'Akun Anda tidak memiliki hak akses yang valid. Silakan hubungi admin.' // <-- UBAH DI SINI
        ]);
    }

    // Jika belum login sama sekali, lempar ke halaman login
    return redirect()->route('login');
});

// ================= GUEST ROUTES (Belum Login) =================
Route::middleware('guest')->controller(AuthenticatedSessionController::class)->group(function () {
    // Login
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store')->name('login.store');

    // Registrasi Pasien (Menambahkan route ini untuk mengatasi error)
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'registerUser')->name('register.store');

    // Lupa Password (Menggunakan alur OTP WhatsApp yang sebelumnya kita bahas)
    Route::get('/forgot-password', 'showForgotForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetOtp')->name('password.email');
    Route::get('/reset-password', 'showResetForm')->name('password.reset.form');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// ================= AUTH ROUTES (Sudah Login) =================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profil Umum
    Route::get('/profil', [ProfilController::class, 'index'])->name('profile');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profile.password.update');

    // Dukungan
    Route::get('/dukungan', [DukunganController::class, 'index'])->name('dukungan');
    Route::post('/dukungan/kirim', [DukunganController::class, 'send'])->name('dukungan.send');

    // ----------------- KHUSUS PASIEN -----------------
    Route::middleware(['role:patient'])->prefix('pasien')->name('pasien.')->group(function () {

        // 1. Dashboard Pasien (Cek Mood)
        Route::get('/skrining-awal', [InitialScreeningController::class, 'index'])->name('skrining-awal');
        Route::post('/mood-process', [InitialScreeningController::class, 'processMood'])->name('mood.process');

        // 2. Rute Intervensi & GAD-7
        Route::get('/intervensi-ringan', [InterventionController::class, 'ringan'])->name('intervensi.ringan');
        Route::get('/intervensi-sedang', [InterventionController::class, 'sedang'])->name('intervensi.sedang');
        Route::get('/gad7', [InterventionController::class, 'gad7Form'])->name('gad7.form');
        Route::post('/gad7', [InterventionController::class, 'processGad7'])->name('gad7.process');

        // Hasil Intervensi GAD-7
        Route::get('/gad7/ringan', [InterventionController::class, 'gad7Ringan'])->name('gad7.ringan');
        Route::get('/gad7/sedang', [InterventionController::class, 'gad7Sedang'])->name('gad7.sedang');
        Route::get('/gad7/berat', [InterventionController::class, 'gad7Berat'])->name('gad7.berat');
    });

    // ----------------- KHUSUS ADMIN -----------------
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        // 1. Dashboard Admin (URL: /admin/dashboard)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 2. Data Pasien (URL: /admin/pasien)
        Route::get('/data-pasien', [PatientController::class, 'index'])->name('pasien');

        // 3. Pertanyaan GAD-7 (URL: /admin/gad-questions)
        Route::get('/gad-questions', [GadQuestionController::class, 'index'])->name('gad-questions');
        Route::post('/gad-questions', [GadQuestionController::class, 'store'])->name('gad-questions.store');
        Route::put('/gad-questions/{id}', [GadQuestionController::class, 'update'])->name('gad-questions.update');
        Route::patch('/gad-questions/{id}/toggle', [GadQuestionController::class, 'toggleStatus'])->name('gad-questions.toggle');

        // 4. Histori Skrining (URL: /admin/screenings)
        Route::get('/screenings', [ScreeningController::class, 'index'])->name('screenings');
    });
});
