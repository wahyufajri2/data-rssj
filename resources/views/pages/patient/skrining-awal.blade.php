@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-5xl md:p-6 lg:p-8" x-data="{ selectedScore: null }">

        {{-- Sapaan --}}
        <div class="mb-8 text-center mt-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                Halo, {{ explode(' ', Auth::user()->name)[0] ?? 'Pasien' }} 👋
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Mari luangkan waktu sejenak untuk mengenali diri sendiri.
            </p>
        </div>

        {{-- Kartu Kuesioner Mood --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-gray-900 md:p-8 lg:p-10">

            <h2 class="mb-8 text-xl font-semibold text-center text-gray-800 dark:text-white/90">
                Bagaimana perasaan Anda hari ini?
            </h2>

            <form action="{{ route('pasien.mood.process') }}" method="POST">
                @csrf

                <input type="hidden" name="mood_score" x-model="selectedScore">

                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 lg:gap-4 mb-8">
                    @for ($i = 0; $i <= 10; $i++)
                        <button type="button" @click="selectedScore = {{ $i }}"
                            :class="selectedScore === {{ $i }} ?
                                'bg-brand-500 text-white border-brand-500 shadow-md scale-110 transform transition-all' :
                                'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-all'"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border text-base font-bold sm:h-12 sm:w-12 lg:h-14 lg:w-14 lg:text-lg">
                            {{ $i }}
                        </button>
                    @endfor
                </div>

                <div
                    class="flex justify-between px-2 text-sm font-medium text-gray-500 dark:text-gray-400 max-w-4xl mx-auto">
                    <span class="flex flex-col items-center gap-1 text-center">
                        <span class="text-2xl lg:text-3xl">😊</span>
                        Tidak Cemas (0)
                    </span>
                    <span class="flex flex-col items-center gap-1 text-center">
                        <span class="text-2xl lg:text-3xl">😟</span>
                        Sangat Cemas (10)
                    </span>
                </div>

                <hr class="my-8 border-gray-100 dark:border-gray-800 max-w-4xl mx-auto">

                <div class="text-center">
                    <button type="submit" :disabled="selectedScore === null"
                        :class="selectedScore === null ? 'opacity-50 cursor-not-allowed bg-gray-400' :
                            'bg-brand-500 hover:bg-brand-600 shadow-theme-md'"
                        class="inline-flex w-full md:w-auto items-center justify-center gap-2 rounded-xl px-10 py-3.5 text-base font-semibold text-white transition-colors">
                        Lanjutkan
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
