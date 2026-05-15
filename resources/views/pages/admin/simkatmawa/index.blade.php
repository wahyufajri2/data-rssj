@extends('layouts.app')

@section('content')
    @use('App\Enums\Role')

    @php
        // Memanggil Helper yang sudah kita buat
        $greeting = \App\Helpers\GreetingHelper::getGreetingData();

        // Memindahkan data object ke variabel agar kode HTML Anda di bawahnya tidak perlu diubah
        $ucapan = $greeting->ucapan;
        $ikonMatahari = $greeting->ikonMatahari;
        $namaLengkap = $greeting->namaLengkap;
    @endphp

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="SIMKATMAWA" />

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

                <div class="flex-grow text-center xl:text-right">
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

            {{-- Bagian Bawah: Konteks SIMKATMAWA --}}
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Selamat Datang di <span class="font-medium text-gray-900 dark:text-white">Modul Integrasi
                        SIMKATMAWA</span>.
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Hak Akses Anda pada aplikasi ini sebagai <span class="font-medium text-gray-800 dark:text-gray-300">PT
                        (Perguruan Tinggi)</span>. Berikut adalah modul-modul sinkronisasi yang dapat Anda akses:
                </p>
            </div>
        </div>

        {{-- Grid Modul SIMKATMAWA --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            {{-- Modul 1: Prestasi Mandiri (HIJAU) --}}
            <a href="{{ route('admin.simkatmawa.prestasimandiri') }}"
                class="group relative flex h-[160px] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-green-500 hover:shadow-green-500/10 dark:border-gray-800 dark:bg-gray-900">
                <div
                    class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-green-500/10 opacity-0 blur-2xl transition-opacity duration-500 pointer-events-none group-hover:opacity-100 dark:bg-green-500/20">
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-gray-500 transition-all duration-300 group-hover:border-green-500/30 group-hover:bg-green-500/10 group-hover:text-green-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                        <svg class="h-5 w-5 transform transition-transform duration-300 group-hover:scale-110"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <h3
                        class="text-base font-medium text-gray-800 transition-colors duration-300 group-hover:text-green-500 dark:text-white/90">
                        Prestasi Mandiri</h3>
                </div>
                <div class="relative z-10 mt-auto flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-green-600 opacity-0 -translate-x-4 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">Buka
                        Modul</span>
                    <div
                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-green-500 text-white shadow-sm transition-all duration-300 group-hover:bg-green-600 group-hover:shadow-md">
                        <svg class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-0.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Modul 2: Rekognisi (KUNING) --}}
            <a href="{{ route('admin.simkatmawa.rekognisi') }}"
                class="group relative flex h-[160px] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-yellow-500 hover:shadow-yellow-500/10 dark:border-gray-800 dark:bg-gray-900">
                <div
                    class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-yellow-500/10 opacity-0 blur-2xl transition-opacity duration-500 pointer-events-none group-hover:opacity-100 dark:bg-yellow-500/20">
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-gray-500 transition-all duration-300 group-hover:border-yellow-500/30 group-hover:bg-yellow-500/10 group-hover:text-yellow-600 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                        <svg class="h-5 w-5 transform transition-transform duration-300 group-hover:scale-110"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <h3
                        class="text-base font-medium text-gray-800 transition-colors duration-300 group-hover:text-yellow-600 dark:text-white/90">
                        Rekognisi</h3>
                </div>
                <div class="relative z-10 mt-auto flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-yellow-600 opacity-0 -translate-x-4 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">Buka
                        Modul</span>
                    <div
                        class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-yellow-500 text-white shadow-sm transition-all duration-300 group-hover:bg-yellow-600 group-hover:shadow-md">
                        <svg class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-0.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 12h16M14 6l6 6-6 6" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Modul 3: Sertifikasi (BIRU) --}}
            <a href="{{ route('admin.simkatmawa.sertifikasi') }}"
                class="group relative flex h-[160px] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-blue-500 hover:shadow-blue-500/10 dark:border-gray-800 dark:bg-gray-900">
                <div
                    class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-500/10 opacity-0 blur-2xl transition-opacity duration-500 pointer-events-none group-hover:opacity-100 dark:bg-blue-500/20">
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-gray-500 transition-all duration-300 group-hover:border-blue-500/30 group-hover:bg-blue-500/10 group-hover:text-blue-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                        <svg class="h-5 w-5 transform transition-transform duration-300 group-hover:scale-110"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <h3
                        class="text-base font-medium text-gray-800 transition-colors duration-300 group-hover:text-blue-500 dark:text-white/90">
                        Sertifikasi</h3>
                </div>
                <div class="relative z-10 mt-auto flex items-center justify-between">
                    <span
                        class="text-sm font-medium text-blue-600 opacity-0 -translate-x-4 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">Buka
                        Modul</span>
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

        </div>
    </div>
@endsection
