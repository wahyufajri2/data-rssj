@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-4xl md:p-6 lg:p-8">

        {{-- Indikator Hasil Skrining GAD-7 (Berat) --}}
        <div class="mb-6 flex justify-center">
            <div
                class="relative inline-flex items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-700 shadow-sm dark:border-red-800/30 dark:bg-red-900/20 dark:text-red-400 transition-colors overflow-hidden">
                <span class="absolute left-0 top-0 h-full w-1 bg-red-500 animate-pulse"></span>
                <svg class="h-5 w-5 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                Hasil Skrining GAD-7: Kecemasan Berat
            </div>
        </div>

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kembali ke Saat Ini (Grounding)</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Teknik ini membantu membawa pikiran Anda
                kembali ke lingkungan sekitar saat merasa sangat cemas.</p>
        </div>

        <div class="space-y-8">

            {{-- Tahap 1: Latihan Napas (Animasi Terintegrasi dengan Progres Siklus) --}}
            <div class="rounded-2xl border border-brand-100 bg-brand-50/50 p-6 dark:border-brand-900/30 dark:bg-brand-900/10 mb-8"
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
                        this.circleClass = 'scale-[2.3] bg-brand-400';
                        this.animDuration = 4000;
                        this.countdown(() => this.runHold());
                    },
                    runHold() {
                        if (!this.isBreathing) return;
                        this.phase = 'Tahan...';
                        this.counter = 2;
                        this.circleClass = 'scale-[2.3] bg-brand-500';
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
                        this.circleClass = 'scale-[1.3] bg-green-400';
                        this.animDuration = 1000;
                        this.hasFinished = true;
                    }
                }">

                <h3 class="mb-3 text-lg font-bold text-brand-800 dark:text-brand-400">1. Awali dengan Napas Dalam</h3>

                <div x-show="!isBreathing && phase === 'Siap'">
                    <p class="text-sm text-brand-900 dark:text-brand-300 mb-4 leading-relaxed">
                        Tarik napas perlahan melalui hidung (4 dtk), tahan (2 dtk), lalu hembuskan perlahan melalui mulut (6
                        dtk). Lakukan 5 kali sebelum melanjutkan.
                    </p>
                    <button @click="startBreathing()"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 py-3.5 text-sm font-semibold text-white shadow-md hover:bg-brand-600 transition-colors">
                        Mulai Latihan Napas
                    </button>
                </div>

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

                    <div class="flex h-64 w-full items-center justify-center my-2 relative">
                        {{-- Animasi Lingkaran --}}
                        <div class="absolute rounded-full opacity-40 ease-in-out dark:opacity-30 h-24 w-24"
                            :class="circleClass" :style="`transition-duration: ${animDuration}ms; transition: all`">
                        </div>
                        {{-- Counter Tengah --}}
                        <div
                            class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm dark:bg-gray-800">
                            <span x-text="counter > 0 ? counter : (hasFinished ? '✓' : '')"
                                class="text-3xl font-bold text-brand-600 dark:text-brand-400">
                            </span>
                        </div>
                    </div>

                    <button x-show="isBreathing" @click="stopBreathing()"
                        class="relative z-20 text-sm font-medium text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                        Berhenti Latihan
                    </button>

                    <p x-show="hasFinished"
                        class="mt-4 text-base font-bold text-green-600 dark:text-green-400 animate-bounce">
                        Bagus! Pikiran Anda mulai tenang. Mari lanjut ke teknik Grounding di bawah.
                    </p>
                </div>
            </div>

            {{-- Tahap 2: Grounding Technique 5-4-3-2-1 (INTERAKTIF) --}}
            <div class="rounded-2xl border border-orange-100 bg-white p-6 shadow-theme-sm dark:border-orange-900/30 dark:bg-gray-900"
                x-data="{
                    step: 1,
                    complete(s) { this.step = s + 1 }
                }">

                <h3 class="mb-8 text-lg font-bold text-orange-800 dark:text-orange-400 text-center">2. Teknik Grounding
                    (5-4-3-2-1)</h3>

                <div class="relative space-y-4">

                    <div class="transition-all duration-500"
                        :class="step < 1 ? 'opacity-30 grayscale' : (step === 1 ? 'scale-100' : 'opacity-50 scale-95')">
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-orange-50 p-5 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/50">
                            <div class="text-4xl animate-bounce" x-show="step === 1">👁️</div>
                            <div class="text-4xl" x-show="step !== 1">👁️</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 dark:text-white">Langkah 1 — 5 Hal yang Dilihat</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">“Sebutkan 5 benda yang dapat
                                    Anda lihat di sekitar Anda.”</p>
                            </div>
                            <button x-show="step === 1" @click="complete(1)"
                                class="rounded-lg bg-orange-500 px-4 py-2 text-xs font-bold text-white hover:bg-orange-600 shadow-sm">Selesai,
                                Lanjut</button>
                            <div x-show="step > 1" class="text-green-500 font-bold text-xl">✓</div>
                        </div>
                    </div>

                    <div x-show="step >= 2" x-transition.duration.500ms class="transition-all duration-500"
                        :class="step === 2 ? 'scale-100' : 'opacity-50 scale-95'">
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-orange-50 p-5 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/50">
                            <div class="text-4xl animate-pulse" x-show="step === 2">✋</div>
                            <div class="text-4xl" x-show="step !== 2">✋</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 dark:text-white">Langkah 2 — 4 Hal yang Disentuh</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">“Sentuh 4 benda di sekitar
                                    Anda dan rasakan teksturnya.”</p>
                            </div>
                            <button x-show="step === 2" @click="complete(2)"
                                class="rounded-lg bg-orange-500 px-4 py-2 text-xs font-bold text-white hover:bg-orange-600">Selesai,
                                Lanjut</button>
                            <div x-show="step > 2" class="text-green-500 font-bold text-xl">✓</div>
                        </div>
                    </div>

                    <div x-show="step >= 3" x-transition.duration.500ms class="transition-all duration-500"
                        :class="step === 3 ? 'scale-100' : 'opacity-50 scale-95'">
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-orange-50 p-5 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/50">
                            <div class="text-4xl" :class="step === 3 ? 'animate-pulse' : ''">👂</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 dark:text-white">Langkah 3 — 3 Hal yang Didengar</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">“Dengarkan 3 suara di
                                    sekitar Anda.”</p>
                            </div>
                            <button x-show="step === 3" @click="complete(3)"
                                class="rounded-lg bg-orange-500 px-4 py-2 text-xs font-bold text-white hover:bg-orange-600">Selesai,
                                Lanjut</button>
                            <div x-show="step > 3" class="text-green-500 font-bold text-xl">✓</div>
                        </div>
                    </div>

                    <div x-show="step >= 4" x-transition.duration.500ms class="transition-all duration-500"
                        :class="step === 4 ? 'scale-100' : 'opacity-50 scale-95'">
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-orange-50 p-5 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/50">
                            <div class="text-4xl" :class="step === 4 ? 'animate-pulse' : ''">🫀</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 dark:text-white">Langkah 4 — 2 Sensasi Tubuh</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">“Perhatikan 2 sensasi pada
                                    tubuh Anda, rasakan napas dan detak jantung Anda.”</p>
                            </div>
                            <button x-show="step === 4" @click="complete(4)"
                                class="rounded-lg bg-orange-500 px-4 py-2 text-xs font-bold text-white hover:bg-orange-600">Selesai,
                                Lanjut</button>
                            <div x-show="step > 4" class="text-green-500 font-bold text-xl">✓</div>
                        </div>
                    </div>

                    <div x-show="step >= 5" x-transition.duration.500ms class="transition-all duration-500"
                        :class="step === 5 ? 'scale-100' : 'opacity-50 scale-95'">
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-orange-50 p-5 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/50">
                            <div class="text-4xl" :class="step === 5 ? 'animate-bounce' : ''">😮‍💨</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 dark:text-white">Langkah 5 — 1 Napas Dalam</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">“Tarik satu napas dalam
                                    secara perlahan dan hembuskan perlahan.”</p>
                            </div>
                            <button x-show="step === 5" @click="complete(5)"
                                class="rounded-lg bg-orange-500 px-4 py-2 text-xs font-bold text-white hover:bg-orange-600">Selesai</button>
                            <div x-show="step > 5" class="text-green-500 font-bold text-xl">✓</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Motivasi & Rujukan (Muncul Bertahap) --}}
            <div
                class="rounded-2xl border border-red-100 bg-red-50 p-8 text-center dark:border-red-900/30 dark:bg-red-900/10">
                <h3 class="font-bold text-red-800 dark:text-red-400 mb-3 text-lg">Perlu Bantuan Lebih Lanjut?</h3>
                <p class="text-sm text-red-900 dark:text-red-300 leading-relaxed mb-8">
                    Ini adalah beberapa cara untuk mengurangi rasa cemas Anda. Jika Anda belum merasa relaks, kami sarankan
                    Anda untuk menghubungi Layanan Konsultasi terdekat.
                </p>

                <div class="space-y-4 font-medium">
                    <p class="text-gray-700 dark:text-gray-300">“Terima kasih sudah meluangkan waktu untuk menenangkan
                        diri.”</p>
                    <p class="text-gray-700 dark:text-gray-300">“Setiap langkah kecil yang Anda lakukan sangat berarti.”
                    </p>
                    <p class="text-brand-600 dark:text-brand-400 text-lg font-bold animate-pulse">“Anda kuat, dan proses
                        ini sedang membawa Anda menuju pemulihan.”</p>
                </div>
            </div>

        </div>

        <div class="mt-10 text-center flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('pasien.skrining-awal') }}"
                class="inline-block rounded-xl bg-gray-100 px-10 py-4 text-sm font-bold text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 transition-colors shadow-sm">
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
