<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuesioner - RSSJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased min-h-screen flex flex-col transition-colors duration-300">
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

    <div class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="max-w-2xl w-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 relative transition-colors duration-300">
            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-emerald-600 to-teal-800 dark:from-emerald-800 dark:to-teal-900 transition-colors"></div>
            
            <div class="relative pt-12 pb-8 px-6 sm:px-10 text-center">
                <div class="w-24 h-24 bg-white dark:bg-gray-800 rounded-full mx-auto shadow-lg flex items-center justify-center mb-6 border-4 border-emerald-50 dark:border-gray-700 transition-colors">
                    <svg class="w-12 h-12 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2 transition-colors">Terima Kasih, {{ session('nama', 'Saudara/i') }}!</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8 transition-colors">Data kuesioner Anda telah berhasil disimpan di sistem kami.</p>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 text-left border border-gray-100 dark:border-gray-700 mb-8 space-y-4 transition-colors">
                    <h3 class="font-bold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 transition-colors">Ringkasan Hasil Anda</h3>
                    
                    <div class="flex items-start gap-4">
                        <div class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg mt-1 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Skor Kesehatan Jiwa (SRQ-20)</p>
                            <p class="text-lg font-bold text-indigo-900 dark:text-indigo-300 transition-colors">{{ session('skor_srq') }} <span class="text-sm font-normal text-gray-600 dark:text-gray-400 ml-2">({{ session('interpretasi_srq') }})</span></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 pt-3 border-t border-gray-200 dark:border-gray-600 transition-colors">
                        <div class="bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 p-2 rounded-lg mt-1 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Skor Kebiasaan Sehari-hari</p>
                            <p class="text-lg font-bold text-emerald-900 dark:text-emerald-300 transition-colors">{{ session('skor_kebiasaan') }} <span class="text-sm font-normal text-gray-600 dark:text-gray-400 ml-2">({{ session('interpretasi_kebiasaan') }})</span></p>
                        </div>
                    </div>
                </div>

                @if(session()->has('skor_srq') && session('skor_srq') > 0)
                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-6 text-left border border-emerald-100 dark:border-emerald-800/50 mb-8 space-y-4 transition-colors">
                    <h3 class="font-bold text-emerald-800 dark:text-emerald-300 border-b border-emerald-200 dark:border-emerald-800/50 pb-2 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tindak Lanjut yang Disarankan
                    </h3>
                    
                    @if(session('skor_srq') >= 1 && session('skor_srq') <= 5)
                    <p class="text-sm text-emerald-700 dark:text-emerald-400">Berdasarkan hasil kuesioner Anda, silakan lakukan langkah-langkah berikut secara berurutan:</p>
                    <ol class="list-decimal list-inside text-sm font-medium text-emerald-800 dark:text-emerald-200 space-y-2 ml-1">
                        <li>Pertahankan Pola Hidup Sehat</li>
                        <li>Mengistirahatkan Jiwa dan Raga (Relaksasi)</li>
                        <li>Mengurai Beban Pikiran (Manajemen Stres)</li>
                        <li>Menghadapi Masalah dengan Cara yang Sehat (Mekanisme Koping)</li>
                    </ol>
                    @elseif(session('skor_srq') >= 6)
                    <p class="text-sm text-emerald-700 dark:text-emerald-400">Berdasarkan hasil kuesioner Anda, silakan lakukan langkah-langkah penanganan berikut secara berurutan:</p>
                    <ol class="list-decimal list-inside text-sm font-medium text-emerald-800 dark:text-emerald-200 space-y-2 ml-1">
                        <li>Mengobrol dari Hati ke Hati dengan Pendamping Terlatih (Konseling)</li>
                        <li>Meredam Pemicu Stres agar Tidak Semakin Berat (Pencegahan)</li>
                        <li>Meneruskan Penanganan ke Ahlinya (Rujukan)</li>
                    </ol>
                    @endif
                </div>
                @endif

                <a href="{{ route('public.kuesioner.create') }}" class="inline-flex justify-center items-center gap-2 rounded-xl bg-emerald-600 px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition-colors">
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</body>
</html>
