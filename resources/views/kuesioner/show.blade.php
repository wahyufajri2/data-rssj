@extends('layouts.app')

@section('title', 'Detail Kuesioner Mandiri')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-800 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight mb-2">Detail Data Kuesioner Mandiri</h2>
                    <p class="text-blue-100 text-lg">Sistem Ranting Siaga Sehat Jiwa</p>
                </div>
                <div class="mt-4 sm:mt-0 opacity-80">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Section 1: Data Diri -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center">
                    <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Informasi Data Diri</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ranting</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->ranting->nama_ranting ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Mengisi</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($kuesioner->tanggal_mengisi)->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->jenis_kelamin }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Umur</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->umur }} Tahun</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Perkawinan</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->status_kawin }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendidikan Terakhir</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->pendidikan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pekerjaan</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->pekerjaan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIK</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->nik }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Agama</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->agama }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuesioner->alamat }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Hasil SRQ -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center">
                    <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Hasil Kuesioner</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-2 flex items-center">
                            Skor SRQ (Self Reporting Questionnaire)
                            <span class="ml-3 px-3 py-1 rounded-full text-sm {{ $kuesioner->skor_srq >= 6 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200' }} font-bold">
                                {{ $kuesioner->skor_srq }}
                            </span>
                        </h4>
                        <div class="mt-3 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($kuesioner->interpretasi_srq)) !!}
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-2 flex items-center">
                            Skor Kebiasaan Sehari-hari
                            @php
                                $color = 'gray';
                                if ($kuesioner->skor_kebiasaan >= 25) $color = 'emerald';
                                elseif ($kuesioner->skor_kebiasaan >= 16) $color = 'amber';
                                else $color = 'red';
                            @endphp
                            <span class="ml-3 px-3 py-1 rounded-full text-sm bg-{{$color}}-100 text-{{$color}}-800 dark:bg-{{$color}}-900/30 dark:text-{{$color}}-400 border border-{{$color}}-200 font-bold">
                                {{ $kuesioner->skor_kebiasaan }} ({{ $kuesioner->interpretasi_kebiasaan }})
                            </span>
                        </h4>
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
