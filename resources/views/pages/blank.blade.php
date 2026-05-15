@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Halaman Kosong" />
        <div
            class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
            <div class="mx-auto w-full max-w-[630px] text-center">
                <h3 class="mb-4 font-semibold text-gray-800 text-theme-xl dark:text-white/90 sm:text-2xl">
                    Halaman Kosong
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                    Ini adalah halaman kosong. Silakan pilih menu dari navigasi untuk memulai.
                </p>
            </div>
        </div>
    </div>
@endsection
