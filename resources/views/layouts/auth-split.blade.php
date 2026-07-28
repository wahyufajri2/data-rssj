<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') - @elseif(isset($title)){{ $title }} - @endif Sistem Ranting Sehat Siaga Jiwa</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo/leaf.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }
                }
            });
        });
        
        // Prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Bubble Animations */
        @keyframes float-slow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        @keyframes float-medium {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-40px, -30px) scale(0.95); }
            66% { transform: translate(40px, -20px) scale(1.05); }
        }

        @keyframes float-fast {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -40px) scale(1.1); }
            66% { transform: translate(-30px, 30px) scale(0.9); }
        }

        .animate-float-slow { animation: float-slow 18s ease-in-out infinite; }
        .animate-float-medium { animation: float-medium 14s ease-in-out infinite; }
        .animate-float-fast { animation: float-fast 10s ease-in-out infinite; }
    </style>
</head>
<body x-data="{ showGuideModal: false, showAboutModal: false }" class="bg-[#2A7B3E] dark:bg-gray-900 text-white font-sans relative overflow-x-hidden min-h-screen flex flex-col antialiased transition-colors duration-300">
    
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 px-6 py-4 flex justify-between items-center shadow-md relative z-20 transition-colors duration-300">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center">
                <img src="{{ asset('images/logo/leaf.svg') }}" alt="Logo Daun" class="w-full h-full object-contain">
            </div>
            <div class="text-gray-800 dark:text-gray-100 font-bold leading-tight">
                <span class="block text-green-700 dark:text-green-400 text-sm md:text-base">Sistem Ranting Siaga</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">Sehat Jiwa terintegrasi</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" @click.prevent="showGuideModal = true" class="hidden md:flex text-sm text-gray-600 dark:text-gray-300 hover:text-green-700 dark:hover:text-green-400 items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Panduan
            </a>
            <a href="{{ route('public.kuesioner.create') }}" class="bg-[#2A7B3E] dark:bg-green-600 text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-green-800 dark:hover:bg-green-500 transition-colors">Isi Kuesioner</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:flex-row relative z-10">
        <!-- Animated Background Bubbles & Shapes -->
        <!-- Huge abstract glowing shapes -->
        <div class="animate-float-slow absolute top-20 right-1/3 w-64 h-64 bg-green-500/30 dark:bg-green-500/10 rounded-full mix-blend-overlay blur-3xl pointer-events-none"></div>
        <div class="animate-float-medium absolute -bottom-20 left-10 w-96 h-96 bg-green-900/60 dark:bg-green-900/40 rounded-full mix-blend-overlay blur-3xl pointer-events-none"></div>
        <div class="animate-float-fast absolute top-10 right-10 w-80 h-80 bg-green-400/30 dark:bg-green-400/10 rounded-full mix-blend-overlay blur-3xl pointer-events-none"></div>

        <!-- Distinct floating bubbles -->
        <div class="animate-float-fast absolute top-1/4 left-1/4 w-12 h-12 bg-white/10 dark:bg-green-400/5 backdrop-blur-sm border border-white/20 rounded-full pointer-events-none"></div>
        <div class="animate-float-slow absolute bottom-1/3 right-1/4 w-24 h-24 bg-white/5 dark:bg-green-400/5 backdrop-blur-md border border-white/10 rounded-full pointer-events-none"></div>
        <div class="animate-float-medium absolute top-1/2 left-10 w-8 h-8 bg-yellow-400/20 backdrop-blur-sm border border-yellow-400/30 rounded-full pointer-events-none"></div>
        <div class="animate-float-slow absolute bottom-12 right-1/3 w-16 h-16 bg-green-300/10 backdrop-blur-sm border border-green-300/20 rounded-full pointer-events-none"></div>
        <div class="animate-float-medium absolute top-32 left-1/2 w-10 h-10 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full pointer-events-none"></div>

        <!-- Decorative Leaves -->
        <!-- Top Left Leaf -->
        <div class="absolute top-0 left-0 w-32 h-32 md:w-48 md:h-48 lg:w-64 lg:h-64 pointer-events-none opacity-80 dark:opacity-60 z-0">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full transform -translate-x-4 -translate-y-4">
                <path d="M0,0 L200,0 C200,0 180,60 120,100 C60,140 0,200 0,200 L0,0 Z" fill="url(#leaf-gradient-1)" />
                <path d="M0,0 L150,0 C150,0 130,40 80,80 C30,120 0,150 0,150 L0,0 Z" fill="url(#leaf-gradient-2)" />
                <defs>
                    <linearGradient id="leaf-gradient-1" x1="0" y1="0" x2="200" y2="200" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#4ade80" stop-opacity="0.6"/>
                        <stop offset="1" stop-color="#166534" stop-opacity="0.8"/>
                    </linearGradient>
                    <linearGradient id="leaf-gradient-2" x1="0" y1="0" x2="150" y2="150" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#a3e635" stop-opacity="0.7"/>
                        <stop offset="1" stop-color="#15803d" stop-opacity="0.9"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <!-- Bottom Right Leaf -->
        <div class="absolute bottom-0 right-0 w-32 h-32 md:w-48 md:h-48 lg:w-64 lg:h-64 pointer-events-none opacity-80 dark:opacity-60 z-0">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full transform translate-x-4 translate-y-4 rotate-180">
                <path d="M0,0 L200,0 C200,0 180,60 120,100 C60,140 0,200 0,200 L0,0 Z" fill="url(#leaf-gradient-3)" />
                <path d="M0,0 L150,0 C150,0 130,40 80,80 C30,120 0,150 0,150 L0,0 Z" fill="url(#leaf-gradient-4)" />
                <defs>
                    <linearGradient id="leaf-gradient-3" x1="0" y1="0" x2="200" y2="200" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#22c55e" stop-opacity="0.6"/>
                        <stop offset="1" stop-color="#14532d" stop-opacity="0.8"/>
                    </linearGradient>
                    <linearGradient id="leaf-gradient-4" x1="0" y1="0" x2="150" y2="150" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#86efac" stop-opacity="0.7"/>
                        <stop offset="1" stop-color="#166534" stop-opacity="0.9"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Left Column (Info) -->
        <div class="flex-1 flex flex-col justify-center px-8 lg:px-20 py-12 lg:py-0 relative z-10">
            <div class="inline-block bg-yellow-600/20 text-yellow-400 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider mb-6 w-max border border-yellow-500/30">
                PLATFORM RESMI PENDATAAN
            </div>
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight mb-6">
                Ranting<br>Siaga<br><span class="text-yellow-400">Sehat Jiwa</span>
            </h1>
            <p class="text-green-100 dark:text-gray-300 text-lg max-w-xl mb-10 leading-relaxed">
                Sistem pendukung keputusan terintegrasi untuk pengelolaan data kesehatan jiwa dan deteksi dini risiko psikososial secara efisien dan akurat.
            </p>
            
            <div class="flex flex-wrap gap-4 mb-16">
                <a href="{{ route('public.kuesioner.create') }}" class="bg-yellow-400 text-green-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-300 transition-colors shadow-lg shadow-yellow-400/20">
                    Mulai Sekarang &rarr;
                </a>
                <a href="#" @click.prevent="showAboutModal = true" class="border border-green-400 text-green-100 dark:text-gray-200 dark:border-gray-500 px-8 py-3 rounded-full font-medium hover:bg-green-700 dark:hover:bg-gray-800 transition-colors">
                    Pelajari Lebih
                </a>
            </div>

            <div class="grid grid-cols-3 gap-8 border-t border-green-700/50 dark:border-gray-700 pt-8 mt-auto lg:mt-0">
                <div>
                    <div class="text-3xl font-bold text-white mb-1">3M+</div>
                    <div class="text-green-300 dark:text-gray-400 text-xs uppercase tracking-wider">Kapasitas Data</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">2</div>
                    <div class="text-green-300 dark:text-gray-400 text-xs uppercase tracking-wider">Metode Kuesioner</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">Real</div>
                    <div class="text-green-300 dark:text-gray-400 text-xs uppercase tracking-wider">Time Monitoring</div>
                </div>
            </div>
        </div>

        <!-- Right Column (Form Area) -->
        <div class="w-full lg:w-[500px] xl:w-[600px] flex items-center justify-center p-6 lg:p-12 relative z-10 bg-black/10 lg:bg-transparent">
            @yield('auth-form')
        </div>
    </div>
    
    <!-- Theme Toggle Button -->
    <div x-data>
        <button @click="$store.theme.toggle()" class="fixed bottom-6 right-6 p-3 rounded-full bg-white dark:bg-gray-800 shadow-xl border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-white hover:scale-110 transition-transform duration-300 z-50 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <!-- Sun icon (shows in dark mode) -->
            <svg x-show="$store.theme.theme === 'dark'" x-cloak class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <!-- Moon icon (shows in light mode) -->
            <svg x-show="$store.theme.theme === 'light'" class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </div>

    <!-- Guide Modal (Panduan) -->
    <div x-show="showGuideModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div x-show="showGuideModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="showGuideModal = false"></div>

        <!-- Modal panel -->
        <div x-show="showGuideModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-100 dark:border-gray-700">
            
            <!-- Header -->
            <div class="bg-emerald-50 dark:bg-gray-800/80 px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Panduan Penggunaan
                </h3>
                <button @click="showGuideModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none rounded-full p-1 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="px-6 py-6 text-gray-600 dark:text-gray-300 space-y-4 max-h-[60vh] overflow-y-auto font-normal">
                <p>Selamat datang di <strong>Sistem Ranting Siaga Sehat Jiwa (RSSJ)</strong>. Berikut adalah panduan singkat penggunaan sistem:</p>
                
                <h4 class="font-bold text-gray-800 dark:text-gray-200 mt-4 text-base">1. Cara Masuk (Login)</h4>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <li>Gunakan alamat email dan kata sandi yang telah didaftarkan.</li>
                    <li>Jika Anda adalah Admin Ranting, Anda akan mendapatkan kredensial dari Superadmin.</li>
                </ul>

                <h4 class="font-bold text-gray-800 dark:text-gray-200 mt-4 text-base">2. Lupa Password</h4>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <li>Klik tautan "Lupa Password?" pada halaman login.</li>
                    <li>Masukkan email Anda untuk menerima tautan reset kata sandi.</li>
                </ul>

                <h4 class="font-bold text-gray-800 dark:text-gray-200 mt-4 text-base">3. Keamanan Akun</h4>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <li>Jaga kerahasiaan kata sandi Anda.</li>
                    <li>Jangan membagikan akun Anda kepada siapapun untuk menjaga integritas data responden.</li>
                </ul>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button @click="showGuideModal = false" type="button" class="inline-flex justify-center rounded-xl border border-transparent bg-emerald-600 px-6 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- About Modal (Pelajari Lebih) -->
    <div x-show="showAboutModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="showAboutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="showAboutModal = false"></div>

        <div x-show="showAboutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100 dark:border-gray-700">
            
            <!-- Header -->
            <div class="bg-emerald-50 dark:bg-gray-800/80 px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tentang Sistem RSSJ
                </h3>
                <button @click="showAboutModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none rounded-full p-1 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="px-6 py-6 text-gray-600 dark:text-gray-300 space-y-4">
                <div class="flex flex-col items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center border border-emerald-200 dark:border-emerald-800">
                        <img src="{{ asset('images/logo/leaf.svg') }}" alt="Logo RSSJ" class="w-12 h-12">
                    </div>
                    <p class="text-center text-lg font-bold text-gray-800 dark:text-gray-200 mt-4">Sistem Pendataan Ranting Siaga Sehat Jiwa</p>
                    <p class="text-center text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 px-3 py-1 rounded-full mt-2">Versi 1.0.0</p>
                </div>
                
                <p class="leading-relaxed text-justify text-sm">
                    <strong>RSSJ (Ranting Siaga Sehat Jiwa)</strong> adalah platform terpadu yang dirancang khusus untuk memantau, mendata, dan menganalisis kondisi kesehatan jiwa secara efisien. Sistem ini mempermudah admin ranting dalam melakukan pendataan kuesioner dan observasi lapangan secara digital, sehingga menggantikan sistem pencatatan manual.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <svg class="w-6 h-6 text-emerald-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <h5 class="font-bold text-gray-800 dark:text-gray-200 text-sm">Aman & Terpercaya</h5>
                        <p class="text-xs mt-1">Data responden dilindungi ketat dan dijaga kerahasiaannya untuk keperluan medis.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <svg class="w-6 h-6 text-emerald-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <h5 class="font-bold text-gray-800 dark:text-gray-200 text-sm">Real-time Data</h5>
                        <p class="text-xs mt-1">Laporan disajikan secara seketika (*real-time*) untuk mempercepat tindakan preventif.</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button @click="showAboutModal = false" type="button" class="inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-2 text-sm font-bold text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</body>
</html>
