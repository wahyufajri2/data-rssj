@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-4xl md:p-6 lg:p-8" x-data="{ showPopup: {{ session('popup') ? 'true' : 'false' }} }">

        {{-- Pop-up Otomatis --}}
        <template x-teleport="body">
            <div x-show="showPopup" style="display: none;"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
                x-transition.opacity>
                <div @click.away="showPopup = false"
                    class="relative w-full max-w-sm rounded-3xl bg-white p-8 text-center shadow-2xl dark:bg-gray-900"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-8 scale-90"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100">

                    <div class="mb-4 text-5xl">😊</div>
                    <h3 class="mb-6 text-xl font-bold text-gray-800 dark:text-white">{{ session('popup') }}</h3>
                    <button @click="showPopup = false"
                        class="w-full rounded-xl bg-brand-500 py-3 font-semibold text-white hover:bg-brand-600 transition-colors">
                        Terima Kasih
                    </button>
                </div>
            </div>
        </template>

        <div class="grid gap-6 md:grid-cols-2">
            {{-- Afirmasi & Edukasi --}}
            <div class="space-y-6">
                <div
                    class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 dark:border-blue-900/30 dark:bg-blue-900/10">
                    <h3 class="mb-2 text-lg font-bold text-blue-800 dark:text-blue-400 flex items-center gap-2">
                        <span>🌤️</span> Semangat untuk Hari Ini
                    </h3>
                    <p class="text-blue-900 dark:text-blue-300">“Anda sudah berusaha dengan sangat baik hari ini 😊”</p>
                </div>

                <div
                    class="rounded-2xl border border-green-100 bg-green-50/50 p-6 dark:border-green-900/30 dark:bg-green-900/10">
                    <h3 class="mb-4 text-lg font-bold text-green-800 dark:text-green-400 flex items-center gap-2">
                        <span>🌱</span> Tips Menjaga Pikiran Tetap Tenang
                    </h3>
                    <ul class="space-y-3 text-sm text-green-900 dark:text-green-300">
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-500">•</span>
                            Istirahat yang cukup membantu tubuh dan pikiran tetap lebih nyaman selama menjalani pengobatan.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-500">•</span>
                            Saat tubuh terasa tegang, coba tarik napas perlahan dan hembuskan secara perlahan sebanyak
                            beberapa kali.
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Checklist Saran --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <span>💡</span> Saran Baik untuk Anda Hari Ini
                </h3>
                <div class="space-y-3" x-data="{ checked1: false, checked2: false, checked3: false }">
                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                        <input type="checkbox" x-model="checked1"
                            class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            :class="checked1 ? 'line-through opacity-50' : ''">Dengarkan musik favorit</span>
                    </label>
                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                        <input type="checkbox" x-model="checked2"
                            class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            :class="checked2 ? 'line-through opacity-50' : ''">Istirahat sejenak</span>
                    </label>
                    <label
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                        <input type="checkbox" x-model="checked3"
                            class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            :class="checked3 ? 'line-through opacity-50' : ''">Ceritakan perasaan Anda pada keluarga</span>
                    </label>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('pasien.skrining-awal') }}"
                        class="inline-block rounded-xl bg-gray-100 px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300">Selesai
                        untuk Hari Ini</a>
                </div>
            </div>
        </div>
    </div>
@endsection
