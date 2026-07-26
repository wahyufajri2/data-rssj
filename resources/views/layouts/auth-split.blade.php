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
<body class="bg-[#2A7B3E] dark:bg-gray-900 text-white font-sans relative overflow-x-hidden min-h-screen flex flex-col antialiased transition-colors duration-300">
    
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
            <a href="#" class="hidden md:flex text-sm text-gray-600 dark:text-gray-300 hover:text-green-700 dark:hover:text-green-400 items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Panduan
            </a>
            <a href="{{ route('login') }}" class="bg-[#2A7B3E] dark:bg-green-600 text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-green-800 dark:hover:bg-green-500 transition-colors">Masuk</a>
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
                <a href="{{ route('register.secret') }}" class="bg-yellow-400 text-green-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-300 transition-colors shadow-lg shadow-yellow-400/20">
                    Mulai Sekarang &rarr;
                </a>
                <a href="#" class="border border-green-400 text-green-100 dark:text-gray-200 dark:border-gray-500 px-8 py-3 rounded-full font-medium hover:bg-green-700 dark:hover:bg-gray-800 transition-colors">
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

</body>
</html>
