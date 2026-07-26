@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto" x-data="{ 
        step: 1,
        srq_answers: Array(20).fill(null),
        kebiasaan_answers: Array(8).fill(null),
        
        submitForm(e) {
            e.preventDefault();
            
            if(this.srq_answers.includes(null) || this.kebiasaan_answers.includes(null)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Mohon lengkapi semua jawaban kuesioner dan kebiasaan.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            let srqScore = this.srq_answers.reduce((a, b) => a + parseInt(b), 0);
            let kebScore = this.kebiasaan_answers.reduce((a, b) => a + parseInt(b), 0);

            let srqInterp = srqScore >= 6 ? 'KIP-K, Manajemen faktor risiko, Rujukan' : 'Edukasi (Pola hidup, Relaksasi, Manajemen Stres, Koping)';
            
            let kebInterp = '';
            if(kebScore >= 25 && kebScore <= 32) kebInterp = 'Kebiasaan Baik';
            else if(kebScore >= 16 && kebScore <= 24) kebInterp = 'Kebiasaan Cukup';
            else kebInterp = 'Kebiasaan Kurang';

            let htmlMsg = `<div class='text-left mt-2 text-sm text-gray-700'>
                <div class='mb-4 bg-indigo-50 p-3 rounded-lg border border-indigo-100'>
                    <strong class='text-gray-900 block mb-1 text-base'>Skor SRQ-20: ${srqScore}</strong>
                    <span class='text-indigo-700 font-medium'>Tindak Lanjut:</span> ${srqInterp}
                </div>
                <div class='bg-emerald-50 p-3 rounded-lg border border-emerald-100'>
                    <strong class='text-gray-900 block mb-1 text-base'>Skor Kebiasaan Sehari-hari: ${kebScore}</strong>
                    <span class='text-emerald-700 font-medium'>Status:</span> ${kebInterp}
                </div>
            </div>
            <p class='mt-5 text-gray-800 font-semibold text-base'>Apakah Anda yakin ingin menyimpan data ini?</p>`;

            Swal.fire({
                title: 'Ringkasan Interpretasi',
                html: htmlMsg,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#059669', // emerald-600
                cancelButtonColor: '#6b7280', // gray-500
                confirmButtonText: 'Ya, Simpan Data',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        },
        
        progressPercent() {
            if(this.step === 1) {
                let filled = this.srq_answers.filter(x => x !== null).length;
                return Math.floor((filled / 20) * 50);
            } else {
                let filled = this.kebiasaan_answers.filter(x => x !== null).length;
                return 50 + Math.floor((filled / 8) * 50);
            }
        }
    }">
        
        <!-- Header Section -->
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-800 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight mb-2">Kuesioner Mandiri</h2>
                    <p class="text-blue-100 text-lg">Skrining Kesehatan Jiwa & Kebiasaan Sehari-hari</p>
                </div>
                <div class="mt-4 sm:mt-0 opacity-80">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            
            <!-- Progress Bar Terintegrasi -->
            <div class="absolute bottom-0 left-0 w-full h-2 bg-black/20">
                <div class="h-full bg-yellow-400 transition-all duration-500 ease-out" :style="`width: ${progressPercent()}%`"></div>
            </div>
        </div>

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

        <form action="{{ route('kuesioner.store') }}" method="POST" @submit="if(step === 2) submitForm($event)" class="relative pb-24">
            @csrf

            <!-- ================= STEP 1 ================= -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="space-y-6" style="display: none;">
                
                <!-- Identitas Diri Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                                <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg mr-3">1</span>
                                Informasi Data Diri
                            </h3>
                            <span class="text-xs font-semibold px-3 py-1 bg-blue-100 text-blue-800 rounded-full">Step 1 dari 2</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if(Auth::user()->isSuperadmin())
                        <div class="mb-6 p-4 rounded-xl border border-indigo-100 bg-indigo-50/30 dark:bg-indigo-900/10">
                            <label class="block text-sm font-semibold text-indigo-900 dark:text-indigo-300 mb-2">Pilih Ranting Tujuan <span class="text-red-500">*</span></label>
                            <select name="ranting_id" class="block w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 py-3 px-4" :required="step === 1">
                                <option value="">-- Silakan Pilih --</option>
                                @foreach($rantings as $ranting)
                                    <option value="{{ $ranting->id }}" {{ old('ranting_id') == $ranting->id ? 'selected' : '' }}>Ranting {{ $ranting->nama_ranting }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">NIK (16 Digit) <span class="text-red-500">*</span></label>
                                <input type="text" name="nik" :required="step === 1" maxlength="16" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mengisi <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_mengisi" :required="step === 1" value="{{ date('Y-m-d') }}" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Kawin <span class="text-red-500">*</span></label>
                                <select name="status_kawin" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Pilih</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Umur <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="umur" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500">Thn</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Anak <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_anak" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Pendidikan <span class="text-red-500">*</span></label>
                                <select name="pendidikan" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Pilih</option>
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="S1">S1</option>
                                    <option value="S2/S3">S2/S3</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Pekerjaan <span class="text-red-500">*</span></label>
                                <input type="text" name="pekerjaan" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">No HP <span class="text-red-500">*</span></label>
                                <input type="text" name="no_hp" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Agama <span class="text-red-500">*</span></label>
                                <input type="text" name="agama" :required="step === 1" value="Islam" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="alamat" :required="step === 1" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SRQ-20 Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 p-1.5 rounded-lg mr-3">2</span>
                            Kuesioner SRQ-20
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 ml-10">Jawab "Ya" atau "Tidak" untuk keluhan yang Anda rasakan 30 hari terakhir.</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $srq_questions = [
                                    'Apakah Anda sering merasa sakit kepala?',
                                    'Apakah Anda kehilangan nafsu makan?',
                                    'Apakah tidur Anda tidak nyenyak?',
                                    'Apakah Anda mudah merasa takut?',
                                    'Apakah Anda merasa cemas, tegang, atau khawatir?',
                                    'Apakah tangan Anda gemetar?',
                                    'Apakah Anda mengalami gangguan pencernaan?',
                                    'Apakah Anda sulit untuk berpikir jernih?',
                                    'Apakah Anda merasa tidak bahagia?',
                                    'Apakah Anda lebih sering menangis?',
                                    'Apakah Anda merasa sulit untuk menikmati kegiatan sehari-hari?',
                                    'Apakah Anda mengalami kesulitan untuk mengambil keputusan?',
                                    'Apakah pekerjaan sehari-hari Anda terganggu?',
                                    'Apakah Anda tidak mampu melakukan hal-hal yang bermanfaat dalam hidup?',
                                    'Apakah Anda kehilangan minat pada berbagai hal?',
                                    'Apakah Anda merasa tidak berharga?',
                                    'Apakah Anda mempunyai pikiran untuk mengakhiri hidup?',
                                    'Apakah Anda merasa lelah sepanjang waktu?',
                                    'Apakah Anda merasa tidak enak di perut?',
                                    'Apakah Anda mudah lelah?'
                                ];
                            @endphp
                            
                            @foreach($srq_questions as $index => $q)
                            <div class="bg-gray-50/80 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-700 transition-colors">
                                <p class="font-medium text-sm text-gray-800 dark:text-gray-200 mb-3"><span class="text-blue-500 mr-1">{{ $index + 1 }}.</span> {{ $q }}</p>
                                <div class="flex gap-2">
                                    <!-- Custom Radio Button for "Ya" -->
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="srq_answers[{{ $index }}]" value="1" x-model="srq_answers[{{ $index }}]" :required="step === 1" class="peer sr-only">
                                        <div class="py-2 px-3 rounded-lg border-2 text-sm font-semibold transition-all
                                            peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700
                                            dark:peer-checked:bg-blue-900/30 dark:peer-checked:border-blue-500 dark:peer-checked:text-blue-300
                                            border-gray-200 bg-white text-gray-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400
                                            hover:bg-gray-50 dark:hover:bg-gray-700">
                                            Ya
                                        </div>
                                    </label>
                                    <!-- Custom Radio Button for "Tidak" -->
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="srq_answers[{{ $index }}]" value="0" x-model="srq_answers[{{ $index }}]" :required="step === 1" class="peer sr-only">
                                        <div class="py-2 px-3 rounded-lg border-2 text-sm font-semibold transition-all
                                            peer-checked:bg-gray-100 peer-checked:border-gray-400 peer-checked:text-gray-800
                                            dark:peer-checked:bg-gray-700 dark:peer-checked:border-gray-500 dark:peer-checked:text-gray-200
                                            border-gray-200 bg-white text-gray-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400
                                            hover:bg-gray-50 dark:hover:bg-gray-700">
                                            Tidak
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= STEP 2 ================= -->
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/30 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 dark:bg-emerald-900/10 rounded-bl-full -z-10"></div>
                    <div class="px-6 py-4 border-b border-emerald-50 dark:border-emerald-900/30 bg-emerald-50/50 dark:bg-emerald-900/20">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-emerald-800 dark:text-emerald-400 flex items-center">
                                <span class="bg-emerald-200 text-emerald-700 p-1.5 rounded-lg mr-3">3</span>
                                Kebiasaan Sehari-hari
                            </h3>
                            <span class="text-xs font-semibold px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full">Step 2 dari 2</span>
                        </div>
                        <p class="text-sm text-emerald-600 dark:text-emerald-300 mt-1 ml-10">Seberapa sering Anda melakukan aktivitas berikut?</p>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @php
                            $kebiasaan = [
                                'Berolahraga minimal 30 menit sehari',
                                'Menghadiri pengajian/kajian agama',
                                'Minum air putih minimal 8 gelas',
                                'Tidur malam 6-8 jam',
                                'Membaca Al Qur\'an',
                                'Makan buah setiap hari',
                                'Makan sayur setiap hari',
                                'Aktifitas fisik (membersihkan rumah, dsb)'
                            ];
                        @endphp

                        @foreach($kebiasaan as $index => $k)
                        <div class="bg-gray-50/80 dark:bg-gray-700/50 p-5 rounded-xl border border-gray-100 dark:border-gray-600">
                            <p class="font-medium text-base text-gray-800 dark:text-gray-200 mb-4">{{ $index + 1 }}. {{ $k }}?</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach(['1' => 'Tidak Pernah', '2' => 'Kadang', '3' => 'Sering', '4' => 'Selalu'] as $val => $label)
                                <label class="text-center cursor-pointer">
                                    <input type="radio" name="kebiasaan_answers[{{ $index }}]" value="{{ $val }}" x-model="kebiasaan_answers[{{ $index }}]" :required="step === 2" class="peer sr-only">
                                    <div class="py-2.5 px-2 rounded-lg border-2 text-sm font-semibold transition-all
                                        peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700
                                        dark:peer-checked:bg-emerald-900/30 dark:peer-checked:border-emerald-500 dark:peer-checked:text-emerald-300
                                        border-gray-200 bg-white text-gray-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400
                                        hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm hover:shadow">
                                        {{ $label }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sticky Navigation Footer -->
            <div class="fixed bottom-0 left-0 w-full xl:w-[calc(100%-290px)] xl:ml-[290px] bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-t border-gray-200 dark:border-gray-800 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] transition-all z-20">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                    
                    <button type="button" x-show="step === 2" @click="step = 1" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 px-6 py-2.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </button>
                    
                    <div x-show="step === 1" class="w-full flex justify-end">
                        <button type="button" @click="
                            let form = $el.closest('form');
                            let allValid = form.checkValidity();
                            if(allValid && !srq_answers.includes(null)) {
                                step = 2;
                                window.scrollTo(0, 0);
                            } else {
                                form.reportValidity();
                                if(srq_answers.includes(null)) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Jawaban Belum Lengkap',
                                        text: 'Mohon jawab semua pertanyaan SRQ-20 terlebih dahulu.',
                                        confirmButtonColor: '#3b82f6',
                                    });
                                }
                            }
                        " class="flex items-center gap-2 bg-blue-600 text-white px-8 py-2.5 rounded-xl hover:bg-blue-700 font-medium transition-colors shadow-lg hover:shadow-blue-500/30">
                            Selanjutnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <div x-show="step === 2" class="flex justify-end" style="display: none;">
                        <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-8 py-2.5 rounded-xl font-bold transition-all shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Simpan Kuesioner
                        </button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>

<!-- Tambahkan CDN SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
