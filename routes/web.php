<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PendataanController;
use App\Http\Controllers\KuesionerMandiriController;
use App\Http\Controllers\PublicKuesionerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Route root redirect ke dashboard
Route::get('/', function () {
    if (Auth::check()) {
        $rolePrefix = Auth::user()->role === 'admin_ranting' ? 'admin-ranting' : Auth::user()->role;
        return redirect()->route('dashboard', ['role' => $rolePrefix]);
    }
    return redirect()->route('login');
});

// Register admin ranting (Public)
Route::get('/register-admin-ranting-secret', [AuthController::class, 'showRegisterAdmin'])->name('register.admin');
Route::post('/register-admin-ranting-secret', [AuthController::class, 'processRegisterAdmin'])->name('register.admin.submit');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'processForgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'processResetPassword'])->name('password.update');
});

// Email Verification Verify Route (Tanpa Auth/Login)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Link verifikasi tidak valid atau sudah kedaluwarsa.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('success', 'Email sudah diverifikasi sebelumnya. Silakan tunggu persetujuan Superadmin.');
    }

    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Data Anda kini telah masuk dan menunggu persetujuan dari Superadmin.');
})->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

// Public Kuesioner Routes
Route::get('/kuesioner-umum', [PublicKuesionerController::class, 'create'])->name('public.kuesioner.create');
Route::post('/kuesioner-umum', [PublicKuesionerController::class, 'store'])->name('public.kuesioner.store');
Route::get('/kuesioner-umum/sukses', function() {
    if (!session()->has('skor_srq')) {
        return redirect()->route('public.kuesioner.create');
    }
    return view('public.kuesioner.success');
})->name('public.kuesioner.success');


// Auth Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Routes (yang butuh login)
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Tautan verifikasi telah dikirim ulang ke email Anda.');
    })->middleware(['throttle:6,1'])->name('verification.send');

    // Register Admin Ranting (Hanya Superadmin) - Dihapus karena sudah dipindah ke public
    Route::middleware(['role:superadmin'])->group(function () {
    });

    Route::middleware(['active_user', 'set_role_prefix'])->prefix('{role}')->group(function () {
        // Profile Routes
        Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

        Route::middleware(['verified'])->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

            // Superadmin Routes
            Route::middleware(['role:superadmin'])->group(function () {
                Route::get('/users', [UserController::class, 'index'])->name('superadmin.users.index');
                Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('superadmin.users.toggle');
                
                // Pengaturan Periode
                Route::get('/periode', [\App\Http\Controllers\PeriodeController::class, 'index'])->name('superadmin.periode.index');
                Route::post('/periode', [\App\Http\Controllers\PeriodeController::class, 'store'])->name('superadmin.periode.store');
                Route::post('/periode/{periode}/toggle', [\App\Http\Controllers\PeriodeController::class, 'toggleActive'])->name('superadmin.periode.toggle');
                Route::delete('/periode/{periode}', [\App\Http\Controllers\PeriodeController::class, 'destroy'])->name('superadmin.periode.destroy');

                // Pengaturan Daerah, Cabang, Ranting
                Route::resource('daerah', \App\Http\Controllers\DaerahController::class)->except(['create', 'show', 'edit'])->names([
                    'index' => 'superadmin.daerah.index',
                    'store' => 'superadmin.daerah.store',
                    'update' => 'superadmin.daerah.update',
                    'destroy' => 'superadmin.daerah.destroy',
                ]);
                Route::resource('cabang', \App\Http\Controllers\CabangController::class)->except(['create', 'show', 'edit'])->names([
                    'index' => 'superadmin.cabang.index',
                    'store' => 'superadmin.cabang.store',
                    'update' => 'superadmin.cabang.update',
                    'destroy' => 'superadmin.cabang.destroy',
                ]);
                Route::resource('ranting', \App\Http\Controllers\RantingController::class)->except(['create', 'show', 'edit'])->names([
                    'index' => 'superadmin.ranting.index',
                    'store' => 'superadmin.ranting.store',
                    'update' => 'superadmin.ranting.update',
                    'destroy' => 'superadmin.ranting.destroy',
                ]);
            });

            // Data Collection Routes (Accessible by both roles, controllers handle data filtering)
            Route::resource('pendataan', \App\Http\Controllers\PendataanController::class);
            Route::resource('kuesioner', \App\Http\Controllers\KuesionerMandiriController::class);

            // Download Data Routes
            Route::get('downloads', [\App\Http\Controllers\DownloadController::class, 'index'])->name('downloads.index');
            Route::post('downloads/export', [\App\Http\Controllers\DownloadController::class, 'export'])->name('downloads.export');
        });
    });
});
