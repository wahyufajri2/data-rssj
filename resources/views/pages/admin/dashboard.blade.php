@extends('layouts.app')

@section('content')
    @php
        // Memanggil Helper yang sudah kita buat
        $greeting = \App\Helpers\GreetingHelper::getGreetingData();

        // Memindahkan data object ke variabel agar kode HTML Anda di bawahnya tidak perlu diubah
        $ucapan = $greeting->ucapan;
        $ikonMatahari = $greeting->ikonMatahari;
        $namaLengkap = $greeting->namaLengkap;
    @endphp

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Dashboard Admin" />

        {{-- Panel Selamat Datang Terintegrasi --}}
        <div
            class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

            {{-- Bagian Atas: Ucapan Dinamis & Nama --}}
            <div class="flex flex-col gap-6 xl:flex-row xl:items-center">
                <div
                    class="flex h-[72px] w-[72px] shrink-0 items-center justify-center rounded-full bg-gray-50 border border-gray-100 shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    @if ($ikonMatahari)
                        <svg class="text-amber-500" width="34" height="34" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v2" />
                            <path d="M4.93 4.93l1.41 1.41" />
                            <path d="M20 12h2" />
                            <path d="M19.07 4.93l-1.41 1.41" />
                            <path d="M15.947 12.65a4 4 0 0 0-5.925-4.128" />
                            <path d="M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z" />
                        </svg>
                    @else
                        <svg class="text-blue-500 dark:text-blue-400" width="34" height="34" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z" />
                            <path d="M10.083 9A6.002 6.002 0 0 1 16 4a4.243 4.243 0 0 0 2 7.973C18 11.981 18 12 18 12" />
                        </svg>
                    @endif
                </div>

                <div class="flex-grow text-center xl:text-left">
                    <p class="mb-1 text-base font-medium text-gray-500 md:text-lg dark:text-gray-400">
                        {{ $ucapan }}
                    </p>
                    <h2 class="text-2xl font-bold text-gray-800 md:text-3xl lg:text-4xl dark:text-white/90">
                        {{ $namaLengkap }}
                    </h2>
                </div>
            </div>

            {{-- Garis Pembatas --}}
            <div class="my-6 border-b border-gray-100 dark:border-gray-800"></div>

            {{-- Bagian Bawah: Konteks Aplikasi --}}
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Selamat datang di <span class="font-medium text-gray-900 dark:text-white">Panel Administrasi
                        EMBRACE</span>.
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Anda memegang peran sebagai <span class="font-medium text-gray-800 dark:text-gray-300">Administrator
                        Utama</span>. Berikut adalah jalan pintas ke berbagai modul kontrol yang tersedia:
                </p>
            </div>
        </div>

        {{-- Grid Modul Akses Cepat Admin & Statistik --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            {{-- Modul 1: Manajemen Pasien (Biru) --}}
            <a href="{{ route('admin.pasien') }}"
                class="group relative flex h-[160px] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-blue-500 hover:shadow-blue-500/10 dark:border-gray-800 dark:bg-gray-900">
                <div
                    class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-500/10 opacity-0 blur-2xl transition-opacity duration-500 pointer-events-none group-hover:opacity-100 dark:bg-blue-500/20">
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-gray-500 transition-all duration-300 group-hover:border-blue-500/30 group-hover:bg-blue-500/10 group-hover:text-blue-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                            <svg class="h-5 w-5 transform transition-transform duration-300 group-hover:scale-110"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3
                            class="text-base font-medium text-gray-800 transition-colors duration-300 group-hover:text-blue-500 dark:text-white/90">
                            Data Pasien
                        </h3>
                    </div>
                    {{-- Statistik Total Pasien --}}
                    <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalPasien ?? 0 }}</h4>
                </div>
                <div class="relative z-10 mt-auto flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-blue-600 opacity-0 -translate-x-4 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">Kelola
                        Pasien</span>
                    <div
                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-blue-500 text-white shadow-sm transition-all duration-300 group-hover:bg-blue-600 group-hover:shadow-md">
                        <svg class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-0.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Modul 2: Histori Skrining Selesai (Hijau Tosca - Ditukar agar logis dengan sesi selesai) --}}
            <a href="{{ route('admin.screenings') }}"
                class="group relative flex h-[160px] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-teal-500 hover:shadow-teal-500/10 dark:border-gray-800 dark:bg-gray-900">
                <div
                    class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-teal-500/10 opacity-0 blur-2xl transition-opacity duration-500 pointer-events-none group-hover:opacity-100 dark:bg-teal-500/20">
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-gray-500 transition-all duration-300 group-hover:border-teal-500/30 group-hover:bg-teal-500/10 group-hover:text-teal-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                            <svg class="h-5 w-5 transform transition-transform duration-300 group-hover:scale-110"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <h3
                            class="text-base font-medium text-gray-800 transition-colors duration-300 group-hover:text-teal-500 dark:text-white/90">
                            Sesi Selesai
                        </h3>
                    </div>
                    {{-- Statistik Sesi Selesai --}}
                    <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $sesiSelesai ?? 0 }}</h4>
                </div>
                <div class="relative z-10 mt-auto flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-teal-600 opacity-0 -translate-x-4 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">Buka
                        Histori</span>
                    <div
                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-teal-500 text-white shadow-sm transition-all duration-300 group-hover:bg-teal-600 group-hover:shadow-md">
                        <svg class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-0.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Modul 3: Peringatan Cemas Berat (Ungu/Merah) --}}
            {{-- Kita arahkan ke screening tapi mungkin difilter, untuk sementara arahkan ke screening --}}
            <a href="{{ route('admin.screenings') }}"
                class="group relative flex h-[160px] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-red-500 hover:shadow-red-500/10 dark:border-gray-800 dark:bg-gray-900">
                <div
                    class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-red-500/10 opacity-0 blur-2xl transition-opacity duration-500 pointer-events-none group-hover:opacity-100 dark:bg-red-500/20">
                </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-gray-500 transition-all duration-300 group-hover:border-red-500/30 group-hover:bg-red-500/10 group-hover:text-red-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                            <svg class="h-5 w-5 transform transition-transform duration-300 group-hover:scale-110"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <h3
                            class="text-base font-medium text-gray-800 transition-colors duration-300 group-hover:text-red-500 dark:text-white/90">
                            Kecemasan Berat
                        </h3>
                    </div>
                    {{-- Statistik Cemas Berat --}}
                    <h4 class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $cemasBerat ?? 0 }}</h4>
                </div>
                <div class="relative z-10 mt-auto flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-red-600 opacity-0 -translate-x-4 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">Pantau
                        Pasien</span>
                    <div
                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-red-500 text-white shadow-sm transition-all duration-300 group-hover:bg-red-600 group-hover:shadow-md">
                        <svg class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-0.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </div>
                </div>
            </a>

        </div>
    </div>
@endsection
