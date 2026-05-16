@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-4xl md:p-6 lg:p-8">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Evaluasi Lanjutan</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Dalam 2 minggu terakhir, seberapa sering Anda terganggu oleh masalah berikut? Silakan pilih jawaban yang
                paling sesuai dengan kondisi Anda.
            </p>
        </div>

        <form action="{{ route('pasien.gad7.process') }}" method="POST" class="space-y-6">
            @csrf

            @foreach ($questions as $index => $q)
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-sm dark:border-gray-800 dark:bg-gray-900 md:p-6">

                    <h3 class="mb-5 text-base font-semibold text-gray-800 dark:text-white md:text-lg">
                        <span class="mr-2 text-brand-500">{{ $index + 1 }}.</span> {{ $q->question }}
                    </h3>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4">
                        <label
                            class="relative flex cursor-pointer items-center rounded-xl border border-gray-200 p-4 hover:bg-gray-50 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 dark:border-gray-700 dark:hover:bg-gray-800 dark:has-[:checked]:bg-brand-900/20">
                            <input type="radio" name="answers[{{ $q->id }}]" value="0" required
                                class="h-4 w-4 border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Tidak Pernah</span>
                        </label>

                        <label
                            class="relative flex cursor-pointer items-center rounded-xl border border-gray-200 p-4 hover:bg-gray-50 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 dark:border-gray-700 dark:hover:bg-gray-800 dark:has-[:checked]:bg-brand-900/20">
                            <input type="radio" name="answers[{{ $q->id }}]" value="1" required
                                class="h-4 w-4 border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Beberapa Hari</span>
                        </label>

                        <label
                            class="relative flex cursor-pointer items-center rounded-xl border border-gray-200 p-4 hover:bg-gray-50 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 dark:border-gray-700 dark:hover:bg-gray-800 dark:has-[:checked]:bg-brand-900/20">
                            <input type="radio" name="answers[{{ $q->id }}]" value="2" required
                                class="h-4 w-4 border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Lebih dari 7 Hari</span>
                        </label>

                        <label
                            class="relative flex cursor-pointer items-center rounded-xl border border-gray-200 p-4 hover:bg-gray-50 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 dark:border-gray-700 dark:hover:bg-gray-800 dark:has-[:checked]:bg-brand-900/20">
                            <input type="radio" name="answers[{{ $q->id }}]" value="3" required
                                class="h-4 w-4 border-gray-300 text-brand-500 focus:ring-brand-500">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Hampir Setiap
                                Hari</span>
                        </label>
                    </div>

                </div>
            @endforeach

            <div class="mt-8 text-center">
                <button type="submit"
                    class="inline-flex w-full md:w-auto items-center justify-center gap-2 rounded-xl bg-brand-500 px-10 py-3.5 text-base font-semibold text-white shadow-md hover:bg-brand-600 transition-colors">
                    Kirim Jawaban & Lihat Hasil
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                        </path>
                    </svg>
                </button>
            </div>

        </form>
    </div>
@endsection
