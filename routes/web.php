<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BlankPageController;
use App\Http\Controllers\DukunganController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('portal');

Route::middleware('guest')->controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store')->name('login.store');

    Route::get('/forgot-password', 'showForgotForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/blank-page', [BlankPageController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profile');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/dukungan', [DukunganController::class, 'index'])->name('dukungan');
    Route::post('/dukungan/kirim', [DukunganController::class, 'send'])->name('dukungan.send');


    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {

    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    });
});
