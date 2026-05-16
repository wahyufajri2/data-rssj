@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-4xl md:p-6 lg:p-8">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Intervensi Relaksasi Gabungan</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Mari bantu tubuh Anda melepas ketegangan yang menumpuk.</p>
        </div>

        <div class="space-y-6">

            {{-- Tahap 1: Latihan Napas (Animasi Terintegrasi) --}}
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
                        this.animDuration = 4000;
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
                        this.animDuration = 6000;
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

                <h3 class="mb-3 text-lg font-bold text-brand-800 dark:text-brand-400">1. Lakukan Relaksasi Napas Dalam</h3>

                {{-- Tampilan Sebelum Mulai --}}
                <div x-show="!isBreathing && phase === 'Siap'">
                    <p class="text-sm text-brand-900 dark:text-brand-300 leading-relaxed mb-4">
                        Sebelum memulai relaksasi otot, mari tenangkan detak jantung terlebih dahulu. Tarik napas perlahan
                        (4 detik), tahan (2 detik), lalu hembuskan (6 detik). Lakukan sebanyak 5 kali putaran.
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
                    <div class="flex h-72 w-full items-center justify-center my-2 relative">
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

                    <p x-show="hasFinished"
                        class="relative z-20 mt-4 text-base font-bold text-green-600 dark:text-green-400 animate-bounce">
                        Bagus! Pikiran Anda mulai tenang. Mari lanjut ke teknik di bawah.
                    </p>
                </div>
            </div>

            {{-- Tahap 2: PMR (Interaktif dengan Alpine.js) --}}
            <div class="rounded-2xl border border-purple-100 bg-white p-6 shadow-theme-sm dark:border-purple-900/30 dark:bg-gray-900"
                x-data="{
                    activeStep: null,
                    timer: null,
                    timeLeft: 0,
                    phase: '', // 'tahan', 'lepas', atau 'selesai'
                    audio: null,
                
                    stepAudio: {
                        1: '{{ asset('storage/audio/pmr-1-persiapan.mp3') }}',
                        2: '{{ asset('storage/audio/pmr-2-tangan.mp3') }}',
                        3: '{{ asset('storage/audio/pmr-3-lengan.mp3') }}',
                        4: '{{ asset('storage/audio/pmr-4-bahu.mp3') }}',
                        5: '{{ asset('storage/audio/pmr-5-wajah.mp3') }}',
                        6: '{{ asset('storage/audio/pmr-6-dada-perut.mp3') }}',
                        7: '{{ asset('storage/audio/pmr-7-kaki.mp3') }}'
                    },
                
                    startStep(stepNumber, holdDuration = 5, releaseDuration = 0) {
                        if (this.activeStep) {
                            this.stopCurrentStep();
                        }
                
                        this.activeStep = stepNumber;
                        this.phase = holdDuration > 0 ? 'tahan' : 'selesai';
                
                        if (this.stepAudio[stepNumber]) {
                            this.audio = new Audio(this.stepAudio[stepNumber]);
                            this.audio.play().catch(e => console.log('Audio tidak ditemukan'));
                        }
                
                        if (holdDuration > 0) {
                            this.timeLeft = holdDuration;
                            this.timer = setInterval(() => {
                                this.timeLeft--;
                                if (this.timeLeft <= 0) {
                                    if (this.phase === 'tahan' && releaseDuration > 0) {
                                        // Pindah ke fase lepaskan perlahan
                                        this.phase = 'lepas';
                                        this.timeLeft = releaseDuration;
                                    } else {
                                        // Timer selesai sepenuhnya
                                        clearInterval(this.timer);
                                        this.phase = 'selesai';
                                    }
                                }
                            }, 1000);
                        }
                    },
                
                    stopCurrentStep() {
                        clearInterval(this.timer);
                        this.timeLeft = 0;
                        this.phase = '';
                        if (this.audio) {
                            this.audio.pause();
                            this.audio.currentTime = 0;
                        }
                    }
                }">

                <h3 class="mb-5 text-lg font-bold text-purple-800 dark:text-purple-400">2. Relaksasi Otot Progresif</h3>

                <div class="space-y-4">

                    {{-- Langkah 1: Persiapan --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 1 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 1 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                1
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Persiapan</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Duduk atau berbaringlah di tempat
                                    yang tenang dengan posisi nyaman, gunakan pakaian longgar, dan pejamkan mata.</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 flex justify-end shrink-0">
                            <button @click="startStep(1, 0)" type="button"
                                :class="activeStep === 1 ? 'bg-purple-600 text-white' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors h-fit">
                                <span x-text="activeStep === 1 ? 'Sedang Dimulai...' : 'Mulai Tahap 1'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Langkah 2: Tangan --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 2 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">

                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 2 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                2
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Tangan</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kepalkan tangan kanan, tahan tegang
                                    selama 5 detik, lalu lepaskan perlahan selama 20-30 detik. Ulangi untuk tangan kiri.</p>
                            </div>
                        </div>

                        <div class="mt-2 sm:mt-0 flex flex-col items-end shrink-0 min-w-[120px]">
                            <button @click="startStep(2, 5, 20)" type="button"
                                :class="activeStep === 2 ? 'bg-purple-600 text-white w-full' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg x-show="activeStep !== 2" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="activeStep === 2 ? 'Berjalan...' : 'Mulai'"></span>
                            </button>

                            {{-- Timer Tahan (Warna Merah) --}}
                            <div x-show="activeStep === 2 && phase === 'tahan'" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                <span class="text-sm font-bold text-red-500">Tahan: <span x-text="timeLeft"></span>s</span>
                            </div>

                            {{-- Timer Lepaskan (Warna Hijau) --}}
                            <div x-show="activeStep === 2 && phase === 'lepas'" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                </span>
                                <span class="text-sm font-bold text-green-500">Lepaskan: <span
                                        x-text="timeLeft"></span>s</span>
                            </div>

                            {{-- Indikator Selesai --}}
                            <div x-show="activeStep === 2 && phase === 'selesai'"
                                class="mt-2 text-sm font-bold text-brand-500">
                                Selesai ✓
                            </div>
                        </div>
                    </div>

                    {{-- Langkah 3: Lengan --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 3 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 3 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                3
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Lengan</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tekuk kedua siku dan tegangkan
                                    otot
                                    bagian lengan atas (tahan 5 detik), lalu lepaskan.</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 flex flex-col items-end shrink-0 min-w-[120px]">
                            <button @click="startStep(3, 5)" type="button"
                                :class="activeStep === 3 ? 'bg-purple-600 text-white w-full' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg x-show="activeStep !== 3" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="activeStep === 3 ? 'Berjalan...' : 'Mulai'"></span>
                            </button>
                            <div x-show="activeStep === 3 && timeLeft > 0" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3"><span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                                        class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                                <span class="text-sm font-bold text-red-500">Tahan: <span
                                        x-text="timeLeft"></span>s</span>
                            </div>
                            <div x-show="activeStep === 3 && timeLeft === 0"
                                class="mt-2 text-sm font-bold text-green-500">Lepaskan...</div>
                        </div>
                    </div>

                    {{-- Langkah 4: Bahu --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 4 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 4 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                4
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Bahu</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Angkat kedua bahu
                                    setinggi-tingginya ke arah telinga, tahan 5 detik, dan lepaskan.</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 flex flex-col items-end shrink-0 min-w-[120px]">
                            <button @click="startStep(4, 5)" type="button"
                                :class="activeStep === 4 ? 'bg-purple-600 text-white w-full' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg x-show="activeStep !== 4" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="activeStep === 4 ? 'Berjalan...' : 'Mulai'"></span>
                            </button>
                            <div x-show="activeStep === 4 && timeLeft > 0" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3"><span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                                        class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                                <span class="text-sm font-bold text-red-500">Tahan: <span
                                        x-text="timeLeft"></span>s</span>
                            </div>
                            <div x-show="activeStep === 4 && timeLeft === 0"
                                class="mt-2 text-sm font-bold text-green-500">Lepaskan...</div>
                        </div>
                    </div>

                    {{-- Langkah 5: Wajah --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 5 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 5 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                5
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Wajah</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kerutkan dahi (tahan 5 dtk), tutup
                                    mata rapat (tahan 5 dtk), dan katupkan rahang (tahan 5 dtk), lalu lepaskan
                                    masing-masing.</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 flex flex-col items-end shrink-0 min-w-[120px]">
                            <button @click="startStep(5, 15)" type="button"
                                :class="activeStep === 5 ? 'bg-purple-600 text-white w-full' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg x-show="activeStep !== 5" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="activeStep === 5 ? 'Berjalan...' : 'Mulai'"></span>
                            </button>
                            <div x-show="activeStep === 5 && timeLeft > 0" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3"><span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                                        class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                                <span class="text-sm font-bold text-red-500">Tahan: <span
                                        x-text="timeLeft"></span>s</span>
                            </div>
                            <div x-show="activeStep === 5 && timeLeft === 0"
                                class="mt-2 text-sm font-bold text-green-500">Lepaskan...</div>
                        </div>
                    </div>

                    {{-- Langkah 6: Dada & Perut --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 6 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 6 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                6
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Dada & Perut</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tarik napas dalam, busungkan dada,
                                    dan kencangkan perut, tahan 5 detik, lalu hembuskan sambil merilekskan perut.</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 flex flex-col items-end shrink-0 min-w-[120px]">
                            <button @click="startStep(6, 5)" type="button"
                                :class="activeStep === 6 ? 'bg-purple-600 text-white w-full' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg x-show="activeStep !== 6" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="activeStep === 6 ? 'Berjalan...' : 'Mulai'"></span>
                            </button>
                            <div x-show="activeStep === 6 && timeLeft > 0" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3"><span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                                        class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                                <span class="text-sm font-bold text-red-500">Tahan: <span
                                        x-text="timeLeft"></span>s</span>
                            </div>
                            <div x-show="activeStep === 6 && timeLeft === 0"
                                class="mt-2 text-sm font-bold text-green-500">Lepaskan...</div>
                        </div>
                    </div>

                    {{-- Langkah 7: Kaki --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border transition-colors"
                        :class="activeStep === 7 ?
                            'border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-700' :
                            'border-gray-100 bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700'">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold transition-colors"
                                :class="activeStep === 7 ? 'bg-purple-500 text-white shadow-md' :
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300'">
                                7
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">Kaki</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Luruskan kaki, tegangkan paha dan
                                    betis (5 detik). Angkat jari kaki ke atas (5 detik), lalu lepaskan.</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 flex flex-col items-end shrink-0 min-w-[120px]">
                            <button @click="startStep(7, 10)" type="button"
                                :class="activeStep === 7 ? 'bg-purple-600 text-white w-full' :
                                    'bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-purple-400'"
                                class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg x-show="activeStep !== 7" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="activeStep === 7 ? 'Berjalan...' : 'Mulai'"></span>
                            </button>
                            <div x-show="activeStep === 7 && timeLeft > 0" class="mt-2 flex items-center gap-2">
                                <span class="relative flex h-3 w-3"><span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                                        class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                                <span class="text-sm font-bold text-red-500">Tahan: <span
                                        x-text="timeLeft"></span>s</span>
                            </div>
                            <div x-show="activeStep === 7 && timeLeft === 0"
                                class="mt-2 text-sm font-bold text-green-500">Lepaskan...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('pasien.skrining-awal') }}"
                class="inline-block rounded-xl bg-brand-500 px-8 py-3 text-sm font-semibold text-white hover:bg-brand-600 shadow-md transition-colors">
                Selesai Latihan
            </a>
        </div>
    </div>
@endsection
