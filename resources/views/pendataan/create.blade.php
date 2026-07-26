@extends('layouts.app')

@section('content')
<!-- Form Pendataan Keluarga (Ranting Siaga Sehat Jiwa) -->
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto" x-data="{ 
        indikator_gj: [], 
        indikator_rmp: [],
        
        get statusKesehatan() {
            if (this.indikator_gj.length > 0) {
                return 'Mengalami Gangguan Jiwa';
            } else if (this.indikator_rmp.length > 0) {
                return 'Resiko Masalah Psikososial';
            }
            return 'Sehat';
        }
    }">
        
        <!-- Header Section -->
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-800 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight mb-2">Form Pendataan Keluarga</h2>
                    <p class="text-emerald-100 text-lg">Sistem Ranting Siaga Sehat Jiwa</p>
                </div>
                <div class="mt-4 sm:mt-0 opacity-80">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>

        <!-- Tampilkan Error Validasi -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-red-800 font-medium">Terdapat kesalahan pengisian:</h3>
                </div>
                <ul class="mt-2 list-disc list-inside text-sm text-red-700 ml-9">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendataan.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section 1: Demografi & Lokasi -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center">
                    <span class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Informasi Demografi & Lokasi</h3>
                </div>
                
                <div class="p-6">
                    @if(Auth::user()->isSuperadmin())
                    <div class="mb-6 p-4 rounded-xl border border-indigo-100 bg-indigo-50/30 dark:bg-indigo-900/10 dark:border-indigo-800/30">
                        <label class="block text-sm font-semibold text-indigo-900 dark:text-indigo-300 mb-2">Pilih Ranting Tujuan (Khusus Superadmin) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="ranting_id" required class="appearance-none block w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white py-3 px-4">
                                <option value="">-- Silakan Pilih Cabang / Ranting --</option>
                                @foreach($rantings as $ranting)
                                    <option value="{{ $ranting->id }}" {{ old('ranting_id') == $ranting->id ? 'selected' : '' }}>
                                        Ranting {{ $ranting->nama_ranting }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-indigo-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">Nama Kepala Keluarga <span class="text-red-500 ml-1">*</span></label>
                            <input type="text" name="nama_kk" placeholder="Masukkan nama lengkap" required class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">Umur <span class="text-red-500 ml-1">*</span></label>
                            <div class="relative">
                                <input type="number" name="umur" placeholder="0" required class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500">Tahun</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">Status Perkawinan <span class="text-red-500 ml-1">*</span></label>
                            <select name="status_kawin" required class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white appearance-none">
                                <option value="">Pilih Status</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">Pendidikan Terakhir <span class="text-red-500 ml-1">*</span></label>
                            <select name="pendidikan" required class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white appearance-none">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah">Tidak Sekolah / Belum Tamat SD</option>
                                <option value="SD">SD Sederajat</option>
                                <option value="SMP">SMP Sederajat</option>
                                <option value="SMA">SMA Sederajat</option>
                                <option value="Diploma">Diploma (D1-D4)</option>
                                <option value="S1">Sarjana (S1)</option>
                                <option value="S2">Magister (S2)</option>
                                <option value="S3">Doktor (S3)</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">Pekerjaan <span class="text-red-500 ml-1">*</span></label>
                            <input type="text" name="pekerjaan" placeholder="Contoh: Petani, Wiraswasta" required class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">Alamat / Dusun <span class="text-red-500 ml-1">*</span></label>
                            <input type="text" name="alamat_dusun" placeholder="Nama Dusun / Jalan" required class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white">
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Rumah / RT RW</label>
                            <input type="text" name="no_rumah" placeholder="Opsional" class="block w-full rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors py-2.5 px-4 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Indikator GJ -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-red-100 dark:border-red-900/30 overflow-hidden transition-all hover:shadow-md relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 dark:bg-red-900/10 rounded-bl-full -z-10"></div>
                <div class="px-6 py-4 border-b border-red-50 dark:border-red-900/30 bg-red-50/50 dark:bg-red-900/20 flex items-center">
                    <span class="bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-red-800 dark:text-red-400">Tanda Gangguan Jiwa</h3>
                        <p class="text-xs text-red-600 dark:text-red-300 mt-0.5">Pilih kartu jika tanda ini dialami anggota keluarga</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                        @php
                            $gj_options = [
                                'Sedih berkepanjangan',
                                'Mendengar suara bisikan',
                                'Bicara atau tertawa sendiri',
                                'Mengamuk tanpa sebab',
                                'Mengurung diri di kamar',
                                'Tidak mau merawat diri (mandi, makan)',
                                'Ketakutan atau curiga yang berlebihan',
                                'Sulit tidur terus-menerus',
                                'Sering lupa (pikun) parah',
                                'Percobaan bunuh diri / menyakiti diri'
                            ];
                        @endphp
                        @foreach($gj_options as $index => $option)
                        <label class="relative flex items-start p-4 rounded-xl cursor-pointer border-2 transition-all duration-200 ease-in-out hover:bg-red-50 dark:hover:bg-red-900/20"
                               :class="indikator_gj.includes('{{ $option }}') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="indikator_gj[]" value="{{ $option }}" x-model="indikator_gj" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-medium" :class="indikator_gj.includes('{{ $option }}') ? 'text-red-800 dark:text-red-300' : 'text-gray-700 dark:text-gray-300'">
                                    {{ $option }}
                                </span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Section 3: Indikator Risiko -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-orange-100 dark:border-orange-900/30 overflow-hidden transition-all hover:shadow-md relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 dark:bg-orange-900/10 rounded-bl-full -z-10"></div>
                <div class="px-6 py-4 border-b border-orange-50 dark:border-orange-900/30 bg-orange-50/50 dark:bg-orange-900/20 flex items-center">
                    <span class="bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-orange-800 dark:text-orange-400">Tanda Risiko Masalah Psikososial</h3>
                        <p class="text-xs text-orange-600 dark:text-orange-300 mt-0.5">Pilih kartu jika kejadian ini dialami anggota keluarga</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                        @php
                            $rmp_options = [
                                'Kehilangan pekerjaan / PHK',
                                'Kehamilan / Pasca Melahirkan',
                                'Memiliki penyakit fisik kronis',
                                'Masalah ekonomi keluarga yang berat',
                                'Kehilangan anggota keluarga (kematian)',
                                'Korban kekerasan dalam rumah tangga (KDRT)'
                            ];
                        @endphp
                        @foreach($rmp_options as $option)
                        <label class="relative flex items-start p-4 rounded-xl cursor-pointer border-2 transition-all duration-200 ease-in-out hover:bg-orange-50 dark:hover:bg-orange-900/20"
                               :class="indikator_rmp.includes('{{ $option }}') ? 'border-orange-500 bg-orange-50 dark:bg-orange-900/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="indikator_rmp[]" value="{{ $option }}" x-model="indikator_rmp" class="w-5 h-5 text-orange-600 border-gray-300 rounded focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-medium" :class="indikator_rmp.includes('{{ $option }}') ? 'text-orange-800 dark:text-orange-300' : 'text-gray-700 dark:text-gray-300'">
                                    {{ $option }}
                                </span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Live Status & Submit Banner -->
            <div class="sticky bottom-4 z-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-5 md:p-6 transition-all duration-300 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status Kesehatan (Otomatis Dihitung)</p>
                    <div class="flex items-center gap-3">
                        <div class="relative flex items-center justify-center w-10 h-10 rounded-full"
                             :class="{
                                 'bg-red-100 text-red-600': statusKesehatan === 'Mengalami Gangguan Jiwa',
                                 'bg-orange-100 text-orange-600': statusKesehatan === 'Resiko Masalah Psikososial',
                                 'bg-emerald-100 text-emerald-600': statusKesehatan === 'Sehat'
                             }">
                            <svg x-show="statusKesehatan === 'Sehat'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <svg x-show="statusKesehatan === 'Resiko Masalah Psikososial'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <svg x-show="statusKesehatan === 'Mengalami Gangguan Jiwa'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 011.789 1.106l1.5 3M15 14h-4m4 0l-3-6m3 6v6m0-6h5"></path></svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold"
                            :class="{
                                'text-red-700 dark:text-red-400': statusKesehatan === 'Mengalami Gangguan Jiwa',
                                'text-orange-600 dark:text-orange-400': statusKesehatan === 'Resiko Masalah Psikososial',
                                'text-emerald-600 dark:text-emerald-400': statusKesehatan === 'Sehat'
                            }" x-text="statusKesehatan">
                        </h3>
                    </div>
                </div>
                
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <span>Simpan Data</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection
