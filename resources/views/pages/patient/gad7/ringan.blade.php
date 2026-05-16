@extends('layouts.patient')

@section('content')
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

    <div class="p-4 mx-auto max-w-3xl md:p-6 lg:p-8">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Relaksasi Napas Dalam</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Membantu mengurangi kecemasan, meningkatkan rasa tenang, dan
                mengendalikan respon tubuh.</p>
        </div>

        {{-- Latihan Napas Interaktif --}}
        <div class="rounded-2xl border border-brand-100 bg-brand-50/50 p-6 dark:border-brand-900/30 dark:bg-brand-900/10 mb-6"
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

            <div x-show="!isBreathing && phase === 'Siap'">
                <div class="space-y-3 text-sm text-brand-900 dark:text-brand-300 mb-6">
                    <p><strong>Langkah 1:</strong> Silakan duduk atau berbaring dengan nyaman. Letakkan tangan di atas paha
                        atau di samping tubuh Anda.</p>
                    <p><strong>Langkah 2:</strong> Tarik napas perlahan melalui hidung selama 4 detik.</p>
                    <p><strong>Langkah 3:</strong> Tahan napas selama 2 detik.</p>
                    <p><strong>Langkah 4:</strong> Hembuskan napas perlahan melalui mulut selama 6 detik.</p>
                    <p><strong>Langkah 5:</strong> Ulangi perlahan sebanyak 5 kali sampai tubuh terasa lebih rileks.</p>
                </div>
                <button @click="startBreathing()"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 py-3.5 text-sm font-semibold text-white shadow-md hover:bg-brand-600 transition-colors">
                    Mulai Relaksasi Sekarang
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

                <h4 x-text="phase" class="text-2xl font-bold text-brand-700 dark:text-brand-300 transition-all"></h4>
                <p x-show="isBreathing" class="text-sm font-bold text-brand-600/80 dark:text-brand-400 mt-1">
                    Siklus ke-<span x-text="cycle"></span> dari 5
                </p>

                <div class="flex h-72 w-full items-center justify-center my-2 relative">
                    <div class="relative flex items-center justify-center h-28 w-28">
                        <div class="absolute inset-0 rounded-full opacity-40 ease-in-out dark:opacity-30"
                            :class="circleClass" :style="`transition-duration: ${animDuration}ms;`">
                        </div>
                        <div
                            class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm dark:bg-gray-800">
                            <span x-text="counter > 0 ? counter : (hasFinished ? '✓' : '')"
                                class="text-3xl font-bold text-brand-600 dark:text-brand-400">
                            </span>
                        </div>
                    </div>
                </div>

                <button x-show="isBreathing" @click="stopBreathing()"
                    class="relative z-20 text-sm font-medium text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                    Berhenti Latihan
                </button>

                <p x-show="hasFinished"
                    class="relative z-20 mt-4 text-base text-center font-bold text-green-600 dark:text-green-400 animate-bounce">
                    Latihan selesai, Anda telah melakukannya dengan sangat baik!
                </p>
            </div>

            {{-- Psychoeducation (Muncul setelah selesai) --}}
            <div x-show="hasFinished" style="display: none;" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-8 rounded-xl bg-white p-6 shadow-sm border border-brand-100 dark:bg-gray-900 dark:border-brand-900/30 text-center relative z-20">
                <h3 class="mb-3 text-lg font-bold text-gray-800 dark:text-white flex items-center justify-center gap-2">
                    <span>🌱</span> Memahami Perasaan Anda
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    "Rasa cemas saat menjalani kemoterapi adalah hal yang wajar. Anda tidak sendiri, dan perasaan ini dapat
                    dikendalikan secara bertahap."
                </p>
                <a href="{{ route('pasien.skrining-awal') }}"
                    class="mt-6 inline-block w-full rounded-xl bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
