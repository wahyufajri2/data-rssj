@extends('layouts.patient')

@section('content')
    <style>
        /* Animasi Bunga Berjatuhan */
        @keyframes fall {
            0% {
                transform: translateY(-10vh) translateX(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(110vh) translateX(20px) rotate(360deg);
                opacity: 0;
            }
        }

        .flower-petal {
            position: absolute;
            top: -10vh;
            z-index: 1;
            pointer-events: none;
            animation: fall linear infinite;
        }

        /* Animasi Lingkaran Berdenyut (Blob) */
        @keyframes pulse-blob {
            0% {
                transform: translate(0px, 0px) scale(1);
                opacity: 0.6;
            }

            33% {
                transform: translate(30px, -40px) scale(1.1);
                opacity: 0.9;
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
                opacity: 0.7;
            }

            100% {
                transform: translate(0px, 0px) scale(1);
                opacity: 0.6;
            }
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            /* Kunci utama efek membaur/glowing */
            z-index: 0;
            pointer-events: none;
            animation: pulse-blob 10s infinite ease-in-out;
        }

        .wave-svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1;
            pointer-events: none;
        }
    </style>

    {{-- Wrapper Utama 1 Layar Penuh --}}
    <div
        class="relative flex h-[calc(100vh-80px)] min-h-[550px] w-full flex-col items-center justify-center overflow-hidden bg-brand-50/20 dark:bg-gray-950 px-4">

        {{-- ================= LINGKARAN BERDENYUT (BLOBS) ================= --}}
        {{-- Lingkaran Ungu --}}
        <div class="blob bg-purple-400/50 dark:bg-purple-800/40 w-72 h-72 md:w-96 md:h-96 top-[-10%] left-[-5%]"
            style="animation-delay: 0s; animation-duration: 12s;"></div>

        {{-- Lingkaran Biru --}}
        <div class="blob bg-blue-400/50 dark:bg-blue-800/40 w-72 h-72 md:w-96 md:h-96 bottom-[-10%] right-[-5%]"
            style="animation-delay: 2s; animation-duration: 14s;"></div>

        {{-- Lingkaran Kuning --}}
        <div class="blob bg-yellow-300/50 dark:bg-yellow-700/30 w-64 h-64 md:w-80 md:h-80 top-[20%] right-[10%]"
            style="animation-delay: 4s; animation-duration: 10s;"></div>

        {{-- ================= BACKGROUND WAVE ================= --}}
        <div class="wave-svg leading-none">
            <svg class="block w-full h-[100px] md:h-[150px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,119.21,189.9,104.58,236.4,92.93,279.4,71.77,321.39,56.44Z"
                    class="fill-brand-100 dark:fill-brand-900/10"></path>
            </svg>
        </div>

        {{-- ================= ANIMASI BUNGA BERJATUHAN ================= --}}
        @php
            $petals = ['🌸', '🌼', '🌺', '✨', '🍃', '🏵️', '🌷', '💮'];
        @endphp

        @foreach (range(1, 20) as $i)
            @php
                $left = rand(2, 98);
                $delay = rand(0, 15);
                $duration = rand(15, 30);
                $sizeClass = rand(0, 1) ? 'text-2xl md:text-3xl' : 'text-3xl md:text-4xl';
                $petal = $petals[array_rand($petals)];
            @endphp
            <div class="flower-petal {{ $sizeClass }}"
                style="left: {{ $left }}%; animation-duration: {{ $duration }}s; animation-delay: -{{ $delay }}s;">
                {{ $petal }}
            </div>
        @endforeach

        {{-- ================= KONTEN UTAMA ================= --}}
        <div class="relative z-10 w-full max-w-4xl" x-data="{ selectedScore: null }">

            {{-- Sapaan --}}
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl drop-shadow-sm">
                    Halo, {{ explode(' ', Auth::user()->name)[0] ?? 'Pasien' }} 👋
                </h1>
                <p class="mt-1.5 text-sm md:text-base text-gray-700 dark:text-gray-300 font-medium max-w-lg mx-auto">
                    Mari luangkan waktu sejenak untuk mengenali diri sendiri.
                </p>
            </div>

            {{-- Kartu Kuesioner Mood --}}
            <div
                class="rounded-3xl border border-white/50 bg-white/50 backdrop-blur-2xl p-5 md:p-8 shadow-2xl dark:border-gray-700/50 dark:bg-gray-900/60 transform transition-all duration-500">

                <h2 class="mb-6 text-lg md:text-xl font-semibold text-center text-gray-900 dark:text-white">
                    Bagaimana perasaan Anda hari ini?
                </h2>

                <form action="{{ route('pasien.mood.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mood_score" x-model="selectedScore">

                    {{-- Tombol Skor --}}
                    <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-6">
                        @for ($i = 0; $i <= 10; $i++)
                            <button type="button" @click="selectedScore = {{ $i }}"
                                :class="selectedScore === {{ $i }} ?
                                    'bg-brand-500 text-white border-brand-500 shadow-xl shadow-brand-500/40 scale-110 transform transition-all duration-300' :
                                    'bg-white/80 text-gray-700 border-gray-200 hover:bg-brand-50 hover:border-brand-300 dark:bg-gray-800/80 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-md'"
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border text-base font-bold sm:h-12 sm:w-12 lg:h-14 lg:w-14">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>

                    {{-- Label Emosi --}}
                    <div
                        class="flex justify-between px-2 sm:px-6 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        <span class="flex flex-col items-center gap-1.5 text-center group">
                            <span
                                class="text-3xl lg:text-4xl drop-shadow-md group-hover:scale-110 transition-transform">😊</span>
                            <span
                                class="bg-brand-100/60 dark:bg-brand-900/40 px-3 py-1 rounded-full text-brand-800 dark:text-brand-300">Tidak
                                Cemas (0)</span>
                        </span>
                        <span class="flex flex-col items-center gap-1.5 text-center group">
                            <span
                                class="text-3xl lg:text-4xl drop-shadow-md group-hover:scale-110 transition-transform">😟</span>
                            <span
                                class="bg-red-100/60 dark:bg-red-900/40 px-3 py-1 rounded-full text-red-800 dark:text-red-300">Sangat
                                Cemas (10)</span>
                        </span>
                    </div>

                    <hr class="my-6 border-gray-200/50 dark:border-gray-700/50 max-w-3xl mx-auto">

                    {{-- Tombol Lanjutkan --}}
                    <div class="text-center">
                        <button type="submit" :disabled="selectedScore === null"
                            :class="selectedScore === null ? 'opacity-50 cursor-not-allowed bg-gray-400 dark:bg-gray-700' :
                                'bg-brand-500 hover:bg-brand-600 shadow-xl shadow-brand-500/30 hover:-translate-y-1 group'"
                            class="inline-flex w-full md:w-auto items-center justify-center gap-2 rounded-2xl px-10 py-3 text-base font-bold text-white transition-all duration-300 transform">
                            <span>Lanjutkan Skrining</span>
                            <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
