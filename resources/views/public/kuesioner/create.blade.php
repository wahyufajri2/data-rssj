<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Mandiri Umum - RSSJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        [x-cloak] { display: none !important; }
        .ts-wrapper .ts-control {
            border-radius: 0.5rem; border-color: #d1d5db; padding: 0.75rem 1rem;
            background-color: #f9fafb; color: #374151;
        }
        .ts-wrapper .ts-control > input { color: #374151; }
        
        .dark .ts-wrapper .ts-control,
        .dark .ts-wrapper.single.input-active .ts-control {
            background-color: #374151 !important; border-color: #4b5563 !important; color: #f3f4f6 !important;
        }
        .dark .ts-wrapper .ts-control > input { color: #f3f4f6 !important; }
        .dark .ts-dropdown { background-color: #374151 !important; border-color: #4b5563 !important; color: #f3f4f6 !important; }
        .dark .ts-dropdown .option { color: #f3f4f6 !important; }
        .dark .ts-dropdown .option.active, 
        .dark .ts-dropdown .option:hover { background-color: #4b5563 !important; color: #fff !important; }
        .ts-wrapper.single .ts-control:after { border-color: #9ca3af transparent transparent transparent !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased min-h-screen pb-24 transition-colors duration-300">
    <!-- Navbar -->
    <nav class="bg-emerald-700 dark:bg-emerald-900 px-6 py-4 flex justify-between items-center shadow-md relative z-20 transition-colors duration-300">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-inner overflow-hidden">
                <img src="{{ asset('images/logo/leaf.svg') }}" alt="Logo" class="w-6 h-6 object-cover">
            </div>
            <div>
                <h1 class="text-white font-extrabold text-xl leading-tight tracking-tight">RSSJ</h1>
                <p class="text-emerald-200 dark:text-emerald-300 text-[10px] uppercase font-bold tracking-widest -mt-1">Ranting Siaga Sehat Jiwa</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <!-- Theme Toggle -->
            <button @click="darkMode = !darkMode" class="text-emerald-100 hover:text-white transition-colors focus:outline-none p-1 rounded-full hover:bg-emerald-600 dark:hover:bg-emerald-800">
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </button>
            <a href="{{ route('login') }}" class="text-emerald-100 dark:text-emerald-200 text-sm font-medium hover:text-white dark:hover:text-white transition-colors">Login Admin &rarr;</a>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto" x-data="{ 
            step: 1,
            srq_answers: Array(20).fill(null),
            kebiasaan_answers: Array(8).fill(null),
            
            submitForm(e) {
                e.preventDefault();
                if(this.srq_answers.includes(null) || this.kebiasaan_answers.includes(null)) {
                    Swal.fire({
                        icon: 'warning', title: 'Peringatan', text: 'Mohon lengkapi semua jawaban kuesioner dan kebiasaan.', confirmButtonColor: '#3085d6',
                        background: this.darkMode ? '#1f2937' : '#fff', color: this.darkMode ? '#fff' : '#545454'
                    });
                    return;
                }
                let form = e.target;
                let ranting = form.querySelector('select[name=ranting_id]').value;
                if(!ranting) {
                    Swal.fire({ 
                        icon: 'warning', title: 'Peringatan', text: 'Mohon pilih Ranting Tujuan terlebih dahulu.',
                        background: this.darkMode ? '#1f2937' : '#fff', color: this.darkMode ? '#fff' : '#545454'
                    });
                    this.step = 1;
                    return;
                }
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin data yang diisikan sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Simpan Data',
                    cancelButtonText: 'Batal',
                    background: this.darkMode ? '#1f2937' : '#fff',
                    color: this.darkMode ? '#fff' : '#545454'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
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
            
            <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-800 dark:from-emerald-800 dark:to-teal-900 opacity-90 transition-colors"></div>
                <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-extrabold tracking-tight mb-2">Kuesioner Mandiri (Umum)</h2>
                        <p class="text-emerald-100 dark:text-emerald-200 text-lg">Skrining Kesehatan Jiwa & Kebiasaan Sehari-hari</p>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-2 bg-black/20 dark:bg-black/40">
                    <div class="h-full bg-yellow-400 transition-all duration-500 ease-out" :style="`width: ${progressPercent()}%`"></div>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <h3 class="text-red-800 dark:text-red-300 font-medium">Terdapat kesalahan pengisian:</h3>
                    </div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-400">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('public.kuesioner.store') }}" method="POST" @submit="if(step === 2) submitForm($event)" class="relative">
                @csrf
                <!-- STEP 1 -->
                <div x-show="step === 1" x-transition class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                                <span class="bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 p-1.5 rounded-lg mr-3">1</span> Informasi Data Diri
                            </h3>
                            <span class="text-xs font-semibold px-3 py-1 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-full">Step 1 dari 2</span>
                        </div>
                        <div class="p-6">
                            <div class="mb-6 p-4 rounded-xl border border-indigo-100 dark:border-indigo-900/30 bg-indigo-50/50 dark:bg-indigo-900/10">
                                <label class="block text-sm font-semibold text-indigo-900 dark:text-indigo-300 mb-2">Pilih Ranting / Desa Anda <span class="text-red-500">*</span></label>
                                <select id="ranting-select" name="ranting_id" class="block w-full" :required="step === 1">
                                    <option value="">-- Ketik untuk mencari ranting --</option>
                                    @foreach($rantings as $ranting)
                                        <option value="{{ $ranting->id }}" {{ old('ranting_id') == $ranting->id ? 'selected' : '' }}>Ranting {{ $ranting->nama_ranting }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama" :required="step === 1" value="{{ old('nama') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">NIK (16 Digit) <span class="text-red-500">*</span></label>
                                    <input type="text" name="nik" :required="step === 1" maxlength="16" value="{{ old('nik') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mengisi <span class="text-red-500">*</span></label>
                                    <input type="text" name="tanggal_mengisi" :required="step === 1" value="{{ old('tanggal_mengisi', date('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <select name="jenis_kelamin" :required="step === 1" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                        <option value="">Pilih</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Kawin <span class="text-red-500">*</span></label>
                                    <select name="status_kawin" :required="step === 1" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                        <option value="">Pilih</option>
                                        <option value="Belum Kawin" {{ old('status_kawin')=='Belum Kawin'?'selected':'' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ old('status_kawin')=='Kawin'?'selected':'' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ old('status_kawin')=='Cerai Hidup'?'selected':'' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_kawin')=='Cerai Mati'?'selected':'' }}>Cerai Mati</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Umur <span class="text-red-500">*</span></label>
                                    <input type="number" name="umur" :required="step === 1" value="{{ old('umur') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Anak <span class="text-red-500">*</span></label>
                                    <input type="number" name="jumlah_anak" :required="step === 1" value="{{ old('jumlah_anak') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Pendidikan <span class="text-red-500">*</span></label>
                                    <select name="pendidikan" :required="step === 1" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
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
                                    <input type="text" name="pekerjaan" :required="step === 1" value="{{ old('pekerjaan') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">No HP <span class="text-red-500">*</span></label>
                                    <input type="text" name="no_hp" :required="step === 1" value="{{ old('no_hp') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Agama <span class="text-red-500">*</span></label>
                                    <input type="text" name="agama" :required="step === 1" value="{{ old('agama', 'Islam') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="alamat" :required="step === 1" value="{{ old('alamat') }}" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white py-2.5 px-3 border focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SRQ-20 -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                                <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 p-1.5 rounded-lg mr-3">2</span> Kuesioner SRQ-20
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ml-10">Jawab "Ya" atau "Tidak" untuk keluhan yang Anda rasakan 30 hari terakhir.</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @php
                                    $srq_questions = [
                                        'Sering sakit kepala?', 'Kehilangan nafsu makan?', 'Tidur tidak nyenyak?', 'Mudah takut?', 'Cemas/tegang/khawatir?',
                                        'Tangan gemetar?', 'Gangguan pencernaan?', 'Sulit berpikir jernih?', 'Merasa tidak bahagia?', 'Sering menangis?',
                                        'Sulit menikmati kegiatan?', 'Sulit mengambil keputusan?', 'Pekerjaan terganggu?', 'Tidak mampu melakukan hal bermanfaat?',
                                        'Kehilangan minat?', 'Merasa tidak berharga?', 'Pikiran mengakhiri hidup?', 'Lelah sepanjang waktu?', 'Tidak enak perut?', 'Mudah lelah?'
                                    ];
                                @endphp
                                @foreach($srq_questions as $index => $q)
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600 hover:border-emerald-300 dark:hover:border-emerald-600 transition-colors">
                                    <p class="font-medium text-sm text-gray-800 dark:text-gray-200 mb-3"><span class="text-emerald-500 dark:text-emerald-400 mr-1">{{ $index + 1 }}.</span> {{ $q }}</p>
                                    <div class="flex gap-2">
                                        <label class="flex-1 text-center cursor-pointer">
                                            <input type="radio" name="srq_answers[{{ $index }}]" value="1" x-model="srq_answers[{{ $index }}]" :required="step === 1" class="peer sr-only">
                                            <div class="py-2 px-3 rounded-lg border-2 text-sm font-semibold transition-all peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 peer-checked:border-emerald-500 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-300 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400">Ya</div>
                                        </label>
                                        <label class="flex-1 text-center cursor-pointer">
                                            <input type="radio" name="srq_answers[{{ $index }}]" value="0" x-model="srq_answers[{{ $index }}]" :required="step === 1" class="peer sr-only">
                                            <div class="py-2 px-3 rounded-lg border-2 text-sm font-semibold transition-all peer-checked:bg-gray-100 dark:peer-checked:bg-gray-700 peer-checked:border-gray-400 dark:peer-checked:border-gray-500 peer-checked:text-gray-800 dark:peer-checked:text-gray-200 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div x-show="step === 2" x-transition x-cloak class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/30 overflow-hidden relative transition-colors">
                        <div class="px-6 py-4 border-b border-emerald-50 dark:border-emerald-900/30 bg-emerald-50/50 dark:bg-emerald-900/20 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-emerald-800 dark:text-emerald-400 flex items-center">
                                <span class="bg-emerald-200 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 p-1.5 rounded-lg mr-3">3</span> Kebiasaan Sehari-hari
                            </h3>
                            <span class="text-xs font-semibold px-3 py-1 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-full">Step 2 dari 2</span>
                        </div>
                        <div class="p-6 space-y-4">
                            @php
                                $kebiasaan = [
                                    'Berolahraga minimal 30 menit sehari', 'Menghadiri pengajian/kajian agama', 'Minum air putih minimal 8 gelas',
                                    'Tidur malam 6-8 jam', 'Membaca Al Qur\'an', 'Makan buah setiap hari', 'Makan sayur setiap hari', 'Aktifitas fisik'
                                ];
                            @endphp
                            @foreach($kebiasaan as $index => $k)
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-5 rounded-xl border border-gray-100 dark:border-gray-600 transition-colors">
                                <p class="font-medium text-base text-gray-800 dark:text-gray-200 mb-4">{{ $index + 1 }}. {{ $k }}?</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach(['1' => 'Tidak Pernah', '2' => 'Kadang', '3' => 'Sering', '4' => 'Selalu'] as $val => $label)
                                    <label class="text-center cursor-pointer">
                                        <input type="radio" name="kebiasaan_answers[{{ $index }}]" value="{{ $val }}" x-model="kebiasaan_answers[{{ $index }}]" :required="step === 2" class="peer sr-only">
                                        <div class="py-2.5 px-2 rounded-lg border-2 text-sm font-semibold transition-all peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/30 peer-checked:border-emerald-500 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-300 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400">{{ $label }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-t border-gray-200 dark:border-gray-800 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-30 transition-colors duration-300">
                    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                        <button type="button" x-show="step === 2" @click="step = 1" class="flex items-center gap-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 font-medium transition-colors">Kembali</button>
                        
                        <div x-show="step === 1" class="w-full flex justify-end">
                            <button type="button" @click="
                                let form = $el.closest('form');
                                let allValid = form.checkValidity();
                                if(allValid && !srq_answers.includes(null)) {
                                    step = 2; window.scrollTo(0, 0);
                                } else {
                                    form.reportValidity();
                                    if(srq_answers.includes(null)) Swal.fire({
                                        icon: 'error', title: 'Belum Lengkap', text: 'Jawab semua pertanyaan SRQ-20.',
                                        background: darkMode ? '#1f2937' : '#fff', color: darkMode ? '#fff' : '#545454'
                                    });
                                }
                            " class="flex items-center gap-2 bg-emerald-600 text-white px-8 py-2.5 rounded-xl hover:bg-emerald-700 font-medium shadow-lg hover:shadow-emerald-500/30 transition-colors">
                                Selanjutnya
                            </button>
                        </div>
                        <div x-show="step === 2" x-cloak class="flex justify-end">
                            <button type="submit" class="flex items-center gap-2 bg-emerald-600 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition-colors">Simpan Kuesioner</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('ranting-select')) {
                new TomSelect("#ranting-select", {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "-- Ketik untuk mencari ranting --"
                });
            }
            
            // Initialize Flatpickr
            flatpickr("input[name='tanggal_mengisi']", {
                dateFormat: "Y-m-d",
                defaultDate: "today",
                allowInput: true
            });
        });
    </script>
</body>
</html>
