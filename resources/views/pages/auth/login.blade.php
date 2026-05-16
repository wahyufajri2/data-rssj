@extends('layouts.fullscreen-layout')

@section('content')
    {{-- Style Tambahan untuk Animasi Custom --}}
    <style>
        /* ================= ANIMASI UNTUK TEMA TERANG ================= */
        /* Animasi Mengambang Bunga Hati (Diperkuat) */
        @keyframes floatAndRotateMencolok {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 0.7;
            }

            25% {
                transform: translateY(-20px) rotate(5deg) scale(1.05);
                opacity: 0.8;
            }

            50% {
                transform: translateY(-10px) rotate(-5deg) scale(1);
                opacity: 0.9;
            }

            75% {
                transform: translateY(-30px) rotate(3deg) scale(1.03);
                opacity: 0.8;
            }
        }

        /* Animasi Gelombang Bergerak Horizontal (Tema Terang) */
        @keyframes waveMoveLight {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }

            /* Menggeser setengah panjang SVG */
        }

        .animate-bunga-hati-mencolok {
            animation: floatAndRotateMencolok 15s ease-in-out infinite;
        }

        /* Kelas untuk Gelombang Tema Terang */
        .animate-wave-light {
            animation: waveMoveLight 20s linear infinite;
            min-width: 200vw;
            /* Pastikan SVG cukup panjang untuk diulang */
        }

        /* Variasi kecepatan untuk lapisan gelombang terang */
        .wave-light-fast {
            animation-duration: 15s;
        }

        .wave-light-slow {
            animation-duration: 30s;
        }


        /* ================= ANIMASI UNTUK TEMA GELAP ================= */
        /* Animasi Gelombang Bergetar/Meliuk Tanpa Henti (Tema Gelap) */
        /* Kita animasikan scaleY dan translateY untuk efek bergelombang */
        @keyframes waveMeliukDark {

            0%,
            100% {
                transform: scaleY(1) translateY(0px);
            }

            50% {
                transform: scaleY(1.1) translateY(-10px);
            }

            /* Sedikit mengembang dan naik */
        }

        /* Kelas untuk Gelombang Tema Gelap (Menggunakan SVG yang sudah ada) */
        .animate-wave-dark-kontinu {
            animation: waveMeliukDark 8s ease-in-out infinite;
            transform-origin: bottom;
            /* Animasi tumbuh dari bawah */
        }

        /* Variasi delay untuk lapisan gelombang gelap */
        .wave-dark-delay-2 {
            animation-delay: 2s;
        }


        /* Utility Delays Umum */
        .delay-2 {
            animation-delay: 2s;
        }

        .delay-4 {
            animation-delay: 4s;
        }

        .delay-6 {
            animation-delay: 6s;
        }
    </style>

    {{-- Wrapper Utama: Tinggi fix seukuran layar (h-screen) dan memotong kelebihan (overflow-hidden) agar tidak ada scrollbar --}}
    <div
        class="relative flex h-screen w-full items-center justify-center overflow-hidden bg-gradient-to-br from-[#FDF6F8] via-[#F8F0FC] to-[#F3E8FF] dark:from-gray-900 dark:via-gray-900 dark:to-[#1a1025] transition-colors duration-500">

        {{-- ================= LAYAR LATAR BELAKANG (TEMA TERANG ONLY) ================= --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none dark:hidden">
            {{-- 1. Elemen "Bunga Hati" mencolok --}}
            <div class="absolute top-[8%] left-[5%] animate-bunga-hati-mencolok">
                <div
                    class="w-40 h-40 md:w-56 md:h-56 rounded-full bg-gradient-to-br from-purple-500 via-purple-400 to-blue-400 blur-2xl opacity-70">
                </div>
            </div>
            <div class="absolute top-[18%] right-[8%] animate-bunga-hati-mencolok delay-2">
                <div
                    class="w-32 h-32 md:w-48 md:h-48 rounded-full bg-gradient-to-tr from-blue-400 via-blue-300 to-purple-300 blur-2xl opacity-70">
                </div>
            </div>
            <div class="absolute bottom-[12%] left-[12%] animate-bunga-hati-mencolok delay-4">
                <div
                    class="w-48 h-48 md:w-64 md:h-64 rounded-full bg-gradient-to-r from-purple-400 via-brand-300 to-blue-400 blur-2xl opacity-70">
                </div>
            </div>
            <div class="absolute bottom-[8%] right-[5%] animate-bunga-hati-mencolok delay-6">
                <div
                    class="w-36 h-36 md:w-52 md:h-52 rounded-full bg-gradient-to-b from-blue-500 via-blue-400 to-purple-400 blur-2xl opacity-70">
                </div>
            </div>

            {{-- 2. Gelombang Bergerak Horizontal (Tema Terang) di bagian bawah --}}
            <div class="absolute bottom-0 left-0 right-0 h-[20vh] opacity-30">
                {{-- Lapisan Gelombang 1 (Cepat, Lebih Terang) --}}
                <svg class="absolute bottom-0 h-full text-brand-300 animate-wave-light wave-light-fast"
                    viewBox="0 0 1440 320" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor"
                        d="M0,224L60,213.3C120,203,240,181,360,181.3C480,181,600,203,720,202.7C840,203,960,181,1080,160C1200,139,1320,117,1380,106.7L1440,96L2880,96L2880,320L2820,320C2700,320,2580,320,2460,320C2340,320,2220,320,2100,320C1980,320,1860,320,1740,320C1620,320,1500,320,1440,320L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
                    </path>
                </svg>
                {{-- Lapisan Gelombang 2 (Lambat, Sedikit Lebih Gelap) --}}
                <svg class="absolute bottom-0 h-[90%] text-purple-300 animate-wave-light wave-light-slow delay-2"
                    viewBox="0 0 1440 320" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor"
                        d="M0,160L60,176C120,192,240,224,360,224C480,224,600,192,720,181.3C840,171,960,181,1080,181.3C1200,181,1320,171,1380,165.3L1440,160L2880,160L2880,320L2820,320C2700,320,2580,320,2460,320C2340,320,2220,320,2100,320C1980,320,1860,320,1740,320C1620,320,1500,320,1440,320L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
                    </path>
                </svg>
            </div>
        </div>

        {{-- ================= LAYAR LATAR BELAKANG (TEMA GELAP ONLY) ================= --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none hidden dark:block">
            {{-- 1. Ambient Glow (Pulsating Blobs) --}}
            <div
                class="absolute -left-20 -top-20 h-[500px] w-[500px] animate-pulse rounded-full bg-brand-900/30 opacity-60 mix-blend-screen blur-3xl duration-1000">
            </div>
            <div
                class="absolute -right-20 -bottom-20 h-[500px] w-[500px] animate-pulse rounded-full bg-purple-900/30 opacity-60 mix-blend-screen blur-3xl duration-1000 [animation-delay:2s]">
            </div>
            <div
                class="absolute bottom-1/2 left-1/2 -translate-x-1/2 translate-y-1/2 h-96 w-96 animate-pulse rounded-full bg-pink-900/20 opacity-40 mix-blend-screen blur-3xl duration-1000 [animation-delay:4s]">
            </div>

            {{-- 2. Gelombang Meliuk/Bergetar Tanpa Henti (Tema Gelap) --}}
            {{-- Kita menimpa posisi SVG gelombang bawah asli di sini agar bisa dianimasikan --}}
            <div class="absolute bottom-0 left-0 right-0 h-[25vh] opacity-20 flex items-end">
                {{-- Menggunakan SVG Gelombang Asli Anda, diberi animasi kontinu --}}
                <svg viewBox="0 0 1440 320" class="w-full h-full text-purple-800 animate-wave-dark-kontinu"
                    preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" fill-opacity="0.5"
                        d="M0,192L48,208C96,224,192,256,288,256C384,256,480,224,576,197.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>
        </div>

        {{-- Gelombang Bawah Statis (Sebagai alas dasar - Muncul di kedua tema) --}}
        <div class="absolute bottom-0 left-0 right-0 opacity-10 pointer-events-none flex items-end h-[20vh]">
            <svg viewBox="0 0 1440 320" class="w-full h-full text-purple-300 dark:text-purple-900"
                preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-opacity="0.5"
                    d="M0,192L48,208C96,224,192,256,288,256C384,256,480,224,576,197.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        {{-- ================= KARTU LOGIN TENGAH (TIDAK BERUBAH) ================= --}}
        <div class="relative z-10 mx-4 w-full max-w-md">
            {{-- Wrapper Card Glassmorphism --}}
            <div
                class="rounded-3xl border border-white/60 bg-white/60 px-6 py-8 shadow-2xl shadow-brand-100/50 backdrop-blur-xl dark:border-gray-700/50 dark:bg-gray-800/60 dark:shadow-none sm:px-10 sm:py-10 transition-all duration-300">

                {{-- Bagian Header Kartu (Logo & Teks) --}}
                <div class="mb-6 text-center">
                    {{-- Logo EMBRACE Terintegrasi --}}
                    <svg class="mx-auto h-20 w-20 mb-3 drop-shadow-xl transition-transform hover:scale-105 duration-300"
                        viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 160 C 100 160, 40 110, 40 70 C 40 40, 65 20, 85 25 C 100 30, 105 45, 105 55 C 105 75, 80 110, 120 145"
                            stroke="url(#gradPurple)" stroke-width="14" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M100 160 C 100 160, 160 110, 160 70 C 160 40, 135 20, 115 25 C 100 30, 95 45, 95 55 C 95 75, 120 110, 80 145"
                            stroke="url(#gradPink)" stroke-width="14" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M 45 135 C 25 125, 15 100, 30 95 C 45 90, 55 115, 45 135 Z" fill="#BDB2FF"
                            opacity="0.9" />
                        <path d="M 30 115 C 15 110, 10 90, 20 85 C 30 80, 40 100, 30 115 Z" fill="#BDB2FF" opacity="0.7" />
                        <path d="M 155 135 C 175 125, 185 100, 170 95 C 155 90, 145 115, 155 135 Z" fill="#A594F9"
                            opacity="0.9" />
                        <path d="M 170 115 C 185 110, 190 90, 180 85 C 170 80, 160 100, 170 115 Z" fill="#A594F9"
                            opacity="0.7" />
                        <defs>
                            <linearGradient id="gradPurple" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#8B5CF6" />
                                <stop offset="100%" stop-color="#6B46C1" />
                            </linearGradient>
                            <linearGradient id="gradPink" x1="100%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#F472B6" />
                                <stop offset="100%" stop-color="#DB2777" />
                            </linearGradient>
                        </defs>
                    </svg>

                    {{-- Teks Sambutan --}}
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 dark:text-white/90 tracking-tight mb-2">
                        Selamat Datang di <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600 dark:from-brand-400 dark:to-purple-400 uppercase tracking-wide">Embrace</span>
                    </h1>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
                        Embrace Your Journey - Ease Your Mind.<br class="hidden sm:block"> Silakan masuk untuk melanjutkan
                        sesi.
                    </p>
                </div>

                {{-- Area Notifikasi --}}
                <div>
                    @if (session('status'))
                        <div
                            class="mb-4 rounded-xl bg-green-50 p-3 text-sm font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/50 shadow-theme-xs">
                            {{ session('status') }}
                        </div>
                    @endif

                    @error('no_hp')
                        <div class="mb-4">
                            <x-ui.alert variant="error" title="Gagal" message="{{ $message }}" :showLink="false" />
                        </div>
                    @enderror

                    {{-- Form Input --}}
                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">

                            <div>
                                <label class="mb-1 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Nomor HP <span
                                        class="ml-1 text-[9px] text-brand-600 bg-brand-50 dark:text-brand-400 dark:bg-brand-900/30 px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Wajib</span>
                                </label>
                                <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                    placeholder="Contoh: 081234567890"
                                    class="@error('no_hp') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror h-11 w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2 text-sm text-gray-800 placeholder:text-gray-400 shadow-theme-xs transition-all focus:border-brand-400 focus:bg-white focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900/60 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-500 dark:focus:bg-gray-900" />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Password <span
                                        class="ml-1 text-[9px] text-brand-600 bg-brand-50 dark:text-brand-400 dark:bg-brand-900/30 px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Wajib</span>
                                </label>
                                <div x-data="{ showPassword: false }" class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        placeholder="Masukkan password Anda"
                                        class="@error('password') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror h-11 w-full rounded-xl border border-gray-200 bg-white/80 py-2 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-theme-xs transition-all focus:border-brand-400 focus:bg-white focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900/60 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-500 dark:focus:bg-gray-900" />
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute top-1/2 right-3 z-30 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-brand-500 dark:text-gray-500 dark:hover:text-brand-400 transition-colors focus:outline-hidden">
                                        <svg x-show="!showPassword" class="fill-current" width="18" height="18"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                                                fill="currentColor" />
                                        </svg>
                                        <svg x-show="showPassword" class="fill-current" width="18" height="18"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            style="display: none;">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0006 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <div x-data="{ checkboxToggle: {{ old('remember') ? 'true' : 'false' }} }">
                                    <label for="checkboxLabelOne"
                                        class="flex cursor-pointer items-center text-[13px] font-medium text-gray-600 select-none hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                        <div class="relative">
                                            <input type="checkbox" id="checkboxLabelOne" name="remember" class="sr-only"
                                                @change="checkboxToggle = !checkboxToggle"
                                                {{ old('remember') ? 'checked' : '' }} />
                                            <div :class="checkboxToggle ? 'border-brand-500 bg-brand-500' :
                                                'bg-white border-gray-300 dark:bg-gray-800 dark:border-gray-600'"
                                                class="mr-2.5 flex h-4 w-4 items-center justify-center rounded-[4px] border-[1.5px] transition-all duration-200">
                                                <span
                                                    :class="checkboxToggle ? 'scale-100 opacity-100' : 'scale-50 opacity-0'"
                                                    class="transition-transform duration-200">
                                                    <svg width="10" height="10" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        Ingat Saya
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}"
                                    class="text-[13px] font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 transition-colors">
                                    Lupa Password?
                                </a>
                            </div>

                            <div class="pt-3">
                                <button
                                    class="bg-gradient-to-r from-brand-600 to-brand-500 hover:from-brand-500 hover:to-brand-400 shadow-lg shadow-brand-500/30 flex w-full items-center justify-center rounded-xl px-4 py-3 text-sm font-bold text-white transition-all transform hover:-translate-y-1 hover:shadow-brand-500/50"
                                    type="submit">
                                    Masuk ke Akun
                                </button>
                            </div>

                            <div class="mt-6 text-center">
                                <p class="text-xs font-medium text-gray-600 dark:text-gray-400">
                                    Belum memiliki akun?
                                    <a href="{{ route('register') }}"
                                        class="font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 transition-colors ml-1 border-b border-transparent hover:border-brand-500 pb-0.5">
                                        Daftar Sekarang
                                    </a>
                                </p>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tombol Toggle Tema (Tetap di pojok kanan bawah) --}}
        <div class="fixed right-6 bottom-6 z-50">
            <button
                class="bg-brand-500 hover:bg-brand-600 shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 inline-flex size-12 items-center justify-center rounded-full text-white transition-all transform hover:scale-105"
                @click.prevent="$store.theme.toggle()">
                <svg class="hidden fill-current dark:block" width="20" height="20" viewBox="0 0 20 20"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                        fill="" />
                </svg>
                <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"
                        fill="" />
                </svg>
            </button>
        </div>

    </div>
@endsection
