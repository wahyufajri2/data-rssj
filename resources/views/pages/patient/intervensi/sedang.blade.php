@extends('layouts.patient')

@section('content')
    {{-- Tambahkan CSS animasi equalizer di bagian atas --}}
    <style>
        @keyframes equalizer {

            0%,
            100% {
                height: 8px;
            }

            50% {
                height: 32px;
            }
        }

        .animate-equalizer {
            animation: equalizer 1s ease-in-out infinite;
        }
    </style>

    <div class="p-4 mx-auto max-w-4xl md:p-6 lg:p-8">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">🌿 Mari Tenangkan Diri Sejenak</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Luangkan beberapa menit untuk kenyamanan Anda.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Koping Intervensi (Napas & Audio) --}}
            <div class="space-y-6">

                {{-- Latihan Napas (Dilengkapi Simulasi Animasi & Timer) --}}
                <div class="rounded-2xl border border-brand-100 bg-brand-50/50 p-6 dark:border-brand-900/30 dark:bg-brand-900/10"
                    x-data="{
                        isBreathing: false,
                        phase: 'Siap',
                        counter: 0,
                        cycle: 0,
                        maxCycle: 5,
                        timer: null,
                        circleClass: 'scale-100 bg-brand-300',
                        animDuration: 0,
                        hasFinished: false,
                    
                        startBreathing() {
                            if (this.isBreathing) return;
                            this.isBreathing = true;
                            this.hasFinished = false;
                            this.cycle = 1;
                            this.runInhale();
                        },
                        stopBreathing() {
                            this.isBreathing = false;
                            clearInterval(this.timer);
                            this.phase = 'Siap';
                            this.counter = 0;
                            this.cycle = 0;
                            this.circleClass = 'scale-100 bg-brand-300';
                            this.animDuration = 500;
                        },
                        runInhale() {
                            if (!this.isBreathing) return;
                            this.phase = 'Tarik Napas...';
                            this.counter = 4;
                            this.circleClass = 'scale-[2.5] bg-brand-400';
                            this.animDuration = 4000; // 4 detik animasi membesar
                            this.countdown(() => this.runHold());
                        },
                        runHold() {
                            if (!this.isBreathing) return;
                            this.phase = 'Tahan...';
                            this.counter = 2;
                            this.circleClass = 'scale-[2.5] bg-brand-500';
                            this.animDuration = 2000;
                            this.countdown(() => this.runExhale());
                        },
                        runExhale() {
                            if (!this.isBreathing) return;
                            this.phase = 'Hembuskan...';
                            this.counter = 6;
                            this.circleClass = 'scale-100 bg-brand-300';
                            this.animDuration = 6000; // 6 detik animasi mengecil
                            this.countdown(() => {
                                if (this.cycle < this.maxCycle) {
                                    this.cycle++;
                                    this.runInhale();
                                } else {
                                    this.finish();
                                }
                            });
                        },
                        countdown(nextStep) {
                            clearInterval(this.timer);
                            this.timer = setInterval(() => {
                                this.counter--;
                                if (this.counter <= 0) {
                                    clearInterval(this.timer);
                                    nextStep();
                                }
                            }, 1000);
                        },
                        finish() {
                            this.isBreathing = false;
                            this.phase = 'Selesai! 🎉';
                            this.counter = 0;
                            this.circleClass = 'scale-[1.5] bg-green-400';
                            this.animDuration = 1000;
                            this.hasFinished = true;
                        }
                    }">

                    <h3 class="mb-3 text-lg font-bold text-brand-800 dark:text-brand-400">A. Latihan Napas Dalam</h3>

                    {{-- Tampilan Sebelum Mulai --}}
                    <div x-show="!isBreathing && phase === 'Siap'">
                        <p class="mb-4 text-sm text-brand-900 dark:text-brand-300 leading-relaxed">
                            Tarik napas perlahan selama 4 detik, tahan 2 detik, lalu hembuskan perlahan selama 6 detik.
                            Ulangi 5 kali.
                        </p>
                        <button @click="startBreathing()"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 py-3 text-sm font-semibold text-white shadow-md hover:bg-brand-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mulai Latihan Napas
                        </button>
                    </div>

                    {{-- Tampilan Simulasi Sedang Berjalan & Selesai --}}
                    <div x-show="isBreathing || hasFinished" style="display: none;" class="flex flex-col items-center py-4">

                        {{-- Indikator Progres Siklus (Dots) --}}
                        <div class="flex gap-2 mb-4">
                            <template x-for="i in maxCycle">
                                <div class="h-2.5 w-8 rounded-full transition-all duration-500"
                                    :class="i <= cycle ? 'bg-brand-500 shadow-sm' : 'bg-gray-200 dark:bg-gray-700'">
                                </div>
                            </template>
                        </div>

                        <h4 x-text="phase" class="text-xl font-bold text-brand-700 dark:text-brand-300 transition-all"></h4>

                        <p x-show="isBreathing" class="text-sm font-bold text-brand-600/80 dark:text-brand-400 mt-1">
                            Siklus ke-<span x-text="cycle"></span> dari <span x-text="maxCycle"></span>
                        </p>

                        {{-- Wrapper Pembungkus Animasi --}}
                        <div class="flex h-72 w-full items-center justify-center my-2">
                            <div class="relative flex items-center justify-center h-28 w-28">
                                <div class="absolute inset-0 rounded-full opacity-40 ease-in-out dark:opacity-30"
                                    :class="circleClass" :style="`transition-duration: ${animDuration}ms;`">
                                </div>

                                <div
                                    class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm dark:bg-gray-800">
                                    <span x-text="counter > 0 ? counter : (hasFinished ? '✓' : '')"
                                        class="text-2xl font-bold text-brand-600 dark:text-brand-400">
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Berhenti --}}
                        <button x-show="isBreathing" @click="stopBreathing()"
                            class="relative z-20 text-sm font-medium text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                            Berhenti Latihan
                        </button>

                        {{-- Pesan Selesai --}}
                        <p x-show="hasFinished"
                            class="relative z-20 mt-4 text-sm text-center font-bold text-green-600 dark:text-green-400 animate-bounce">
                            Latihan selesai, Anda telah melakukannya dengan sangat baik!
                        </p>
                    </div>
                </div>

                {{-- Relaksasi Audio (Dilengkapi Pemutar Audio & Alpine.js) --}}
                <div class="rounded-2xl border border-purple-100 bg-purple-50/50 p-6 dark:border-purple-900/30 dark:bg-purple-900/10"
                    x-data="{
                        isPlaying: false,
                        currentTrack: 'alam',
                        audio: null,
                        tracks: {
                            // Ganti URL ini sesuai dengan lokasi file Anda di public/storage
                            'alam': '{{ asset('storage/audio/suara-alam.mp3') }}',
                            'musik': '{{ asset('storage/audio/al-quran-tenang.mp3') }}'
                        },
                        init() {
                            this.audio = new Audio(this.tracks[this.currentTrack]);
                            this.audio.loop = true; // Musik akan berulang otomatis
                        },
                        togglePlay() {
                            if (this.isPlaying) {
                                this.audio.pause();
                                this.isPlaying = false;
                            } else {
                                this.audio.play();
                                this.isPlaying = true;
                            }
                        },
                        changeTrack(track) {
                            if (this.currentTrack === track) return;
                    
                            this.currentTrack = track;
                            let wasPlaying = this.isPlaying;
                    
                            this.audio.pause();
                            this.audio = new Audio(this.tracks[track]);
                            this.audio.loop = true;
                    
                            if (wasPlaying) {
                                this.audio.play();
                            }
                        }
                    }">

                    <h3 class="mb-3 text-lg font-bold text-purple-800 dark:text-purple-400">B. Relaksasi Audio</h3>
                    <p class="mb-4 text-sm text-purple-900 dark:text-purple-300">
                        Pilih dan dengarkan audio untuk merilekskan pikiran Anda.
                    </p>

                    {{-- Pilihan Audio (Tab Switch) --}}
                    <div
                        class="flex gap-2 mb-6 p-1 bg-white/60 dark:bg-gray-800/50 rounded-lg border border-purple-200 dark:border-purple-800/50">
                        <button @click="changeTrack('alam')" type="button"
                            :class="currentTrack === 'alam' ?
                                'bg-purple-100 text-purple-700 dark:bg-purple-900/60 dark:text-purple-300 font-semibold shadow-sm' :
                                'text-gray-500 hover:text-purple-600'"
                            class="flex-1 py-2 text-sm rounded-md transition-all">
                            Suara Alam
                        </button>
                        <button @click="changeTrack('musik')" type="button"
                            :class="currentTrack === 'musik' ?
                                'bg-purple-100 text-purple-700 dark:bg-purple-900/60 dark:text-purple-300 font-semibold shadow-sm' :
                                'text-gray-500 hover:text-purple-600'"
                            class="flex-1 py-2 text-sm rounded-md transition-all">
                            Murottal Al-Qur'an
                        </button>
                    </div>

                    {{-- Animasi Visualizer Musik --}}
                    <div class="flex justify-center items-end gap-1.5 h-10 mb-6">
                        <template x-for="i in 5">
                            <div class="w-2.5 bg-purple-500 rounded-t-sm transition-all"
                                :class="isPlaying ? 'animate-equalizer' : 'h-2'"
                                :style="isPlaying ? `animation-delay: ${i * 0.15}s` : ''"></div>
                        </template>
                    </div>

                    {{-- Tombol Play / Pause --}}
                    <button @click="togglePlay()" type="button"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-purple-500 py-3 text-sm font-semibold text-white shadow-md hover:bg-purple-600 transition-colors">

                        <svg x-show="!isPlaying" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>

                        <svg x-show="isPlaying" style="display: none;" class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>

                        <span x-text="isPlaying ? 'Jeda Audio' : 'Dengarkan Audio'"></span>
                    </button>
                </div>

                {{-- Pesan Afirmasi --}}
                <div
                    class="rounded-2xl border border-orange-100 bg-orange-50/50 p-6 dark:border-orange-900/30 dark:bg-orange-900/10">
                    <h3 class="mb-2 text-lg font-bold text-orange-800 dark:text-orange-400 flex items-center gap-2">
                        <span>🌤️</span> Pesan untuk Anda
                    </h3>
                    <p class="text-sm font-medium italic text-orange-900 dark:text-orange-300 mt-2">
                        "Tubuh dan pikiran Anda sama-sama membutuhkan perhatian. Satu langkah kecil tetap merupakan
                        kemajuan."
                    </p>
                </div>
            </div>

            {{-- Edukasi & Tips --}}
            <div class="space-y-6">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-3 text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <span>🌱</span> Memahami Kecemasan
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Kecemasan dapat muncul ketika tubuh dan pikiran menghadapi situasi yang melelahkan. Mengenali
                        perasaan dan memberi waktu untuk diri sendiri dapat membantu Anda merasa lebih tenang.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <span>💡</span> Hal yang Bisa Membantu Hari Ini
                    </h3>

                    <div class="space-y-3" x-data="{ chk1: false, chk2: false, chk3: false, chk4: false, chk5: false }">

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                            <input type="checkbox" x-model="chk1"
                                class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 transition-all"
                                :class="chk1 ? 'line-through opacity-50' : ''">Duduk dan tarik napas perlahan selama 1
                                menit</span>
                        </label>

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                            <input type="checkbox" x-model="chk2"
                                class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 transition-all"
                                :class="chk2 ? 'line-through opacity-50' : ''">Ceritakan perasaan Anda kepada orang
                                terpercaya</span>
                        </label>

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                            <input type="checkbox" x-model="chk3"
                                class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 transition-all"
                                :class="chk3 ? 'line-through opacity-50' : ''">Dengarkan musik yang menenangkan</span>
                        </label>

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                            <input type="checkbox" x-model="chk4"
                                class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 transition-all"
                                :class="chk4 ? 'line-through opacity-50' : ''">Istirahat sejenak dari pikiran yang
                                melelahkan</span>
                        </label>

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                            <input type="checkbox" x-model="chk5"
                                class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 transition-all"
                                :class="chk5 ? 'line-through opacity-50' : ''">Fokus menjalani hari ini saja</span>
                        </label>

                    </div>
                </div>
            </div>

        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('pasien.skrining-awal') }}"
                class="inline-block rounded-xl bg-gray-100 px-8 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                Selesai untuk Hari Ini
            </a>
        </div>
    </div>
@endsection
