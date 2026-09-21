@extends('layouts.app')

@section('title', 'Detail Pendataan Keluarga')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-800 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight mb-2">Detail Data Pendataan Keluarga</h2>
                    <p class="text-blue-100 text-lg">Sistem Ranting Siaga Sehat Jiwa</p>
                </div>
                <div class="mt-4 sm:mt-0 opacity-80">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Section 1: Demografi & Lokasi -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center">
                    <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Informasi Demografi & Lokasi</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ranting</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->ranting->nama_ranting ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. KK</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->no_kk }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIK</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->nik }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status di Keluarga</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->status_keluarga }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->nama_lengkap }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Umur</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->umur }} Tahun</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Perkawinan</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->status_kawin }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendidikan Terakhir</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->pendidikan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pekerjaan</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->pekerjaan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat (Dusun/Jalan)</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->alamat_dusun }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Rumah / RT RW</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $pendataan->no_rumah ?: '-' }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Indikator & Status -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center">
                    <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Indikator & Status Kesehatan</h3>
                </div>
                
                <div class="p-6">
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-4">Indikator Gangguan Jiwa:</h4>
                        @if(empty($pendataan->indikator_gj))
                            <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada indikator yang dipilih.</p>
                        @else
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-1">
                                @foreach($pendataan->indikator_gj as $indikator)
                                    <li>{{ $indikator }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="mb-8 border-t border-gray-100 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-4">Indikator Resiko Masalah Psikososial:</h4>
                        @if(empty($pendataan->indikator_rmp))
                            <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada indikator yang dipilih.</p>
                        @else
                            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-1">
                                @foreach($pendataan->indikator_rmp as $indikator)
                                    <li>{{ $indikator }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-4">Kesimpulan Status Kesehatan</h4>
                        <div class="flex items-center gap-3">
                            @if(strtolower($pendataan->status_kesehatan) == 'jiwa')
                                <span class="bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 px-4 py-2 rounded-full font-bold text-sm border border-red-200 dark:border-red-800 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span> Mengalami Gangguan Jiwa
                                </span>
                            @elseif(strtolower($pendataan->status_kesehatan) == 'resiko')
                                <span class="bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 px-4 py-2 rounded-full font-bold text-sm border border-amber-200 dark:border-amber-800 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span> Resiko Masalah Psikososial
                                </span>
                            @else
                                <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 px-4 py-2 rounded-full font-bold text-sm border border-emerald-200 dark:border-emerald-800 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Sehat
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-8 pb-10">
                <button type="button" onclick="window.close()" class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Tutup Tab
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
