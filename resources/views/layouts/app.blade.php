<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') - @elseif(isset($title)){{ $title }} - @endif Sistem Ranting Sehat Siaga Jiwa</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo/leaf.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables Tailwind CSS -->
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css" rel="stylesheet">

    <!-- Alpine.js -->
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                        'light';
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
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark');
                    }
                }
            });

            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Apply dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
            }
        })();
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

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

        /* Custom DataTables 2.x Tailwind adjustments for Dark Mode */
        .dark .dt-container {
            color: #d1d5db !important; /* text-gray-300 */
        }
        
        .dark .dt-length select,
        .dark .dt-search input {
            background-color: #1f2937 !important; /* bg-gray-800 */
            color: #f3f4f6 !important; /* text-gray-100 */
            border-color: #4b5563 !important; /* border-gray-600 */
        }
        
        .dark .dt-info {
            color: #9ca3af !important; /* text-gray-400 */
        }
        
        .dark .dt-paging .pagination a {
            color: #d1d5db !important; /* text-gray-300 */
            background-color: #1f2937 !important; /* bg-gray-800 */
            border-color: #374151 !important; /* border-gray-700 */
        }
        
        .dark .dt-paging .pagination a.current {
            background-color: #3b82f6 !important; /* bg-blue-500 */
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }
        
        .dark .dt-paging .pagination a:hover:not(.current):not(.disabled) {
            background-color: #374151 !important;
            color: #ffffff !important;
        }

        .dark .dt-paging .pagination a.disabled {
            color: #4b5563 !important; /* text-gray-600 */
            background-color: transparent !important;
        }
        
        /* Table Headers & Borders */
        .dark table.dataTable thead th, 
        .dark table.dataTable thead td {
            border-bottom: 1px solid #374151 !important;
            color: #f3f4f6 !important; /* text-gray-100 */
            background-color: rgba(55, 65, 81, 0.5) !important; /* bg-gray-700/50 */
        }
        
        .dark table.dataTable.no-footer {
            border-bottom: 1px solid #374151 !important;
        }
        
        .dark table.dataTable tbody td {
            color: #d1d5db !important;
            border-bottom-color: #374151 !important;
        }
        
        .dark table.dataTable tbody tr.even {
            background-color: rgba(17, 24, 39, 0.5) !important; /* bg-gray-900/50 */
        }

        .dark table.dataTable tbody tr:hover {
            background-color: rgba(55, 65, 81, 0.5) !important; /* bg-gray-700/50 */
        }
        
        .dark table.dataTable tbody tr td.dataTables_empty,
        .dark table.dataTable tbody tr.empty td {
            color: #9ca3af !important;
            text-align: center !important;
        }

        table.dataTable tbody tr td.dataTables_empty,
        table.dataTable tbody tr.empty td {
            text-align: center !important;
        }
    </style>


</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300" x-data="{ 'loaded': true }" x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
const checkMobile = () => {
    if (window.innerWidth < 1280) {
        $store.sidebar.setMobileOpen(false);
        $store.sidebar.isExpanded = false;
    } else {
        $store.sidebar.isMobileOpen = false;
        $store.sidebar.isExpanded = true;
    }
};
window.addEventListener('resize', checkMobile);">

    {{-- preloader --}}
    <x-common.preloader />
    {{-- preloader end --}}

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            @yield('content')
        </div>

    </div>

    <x-ui.toast />

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables & Tailwind Integration -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>
<!-- DataTables bahasa Indonesia (inline, tanpa CDN eksternal) -->
<script>
    window.dtLangID = {
        sEmptyTable:     "Tidak ada data yang tersedia pada tabel ini",
        sInfo:           "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        sInfoEmpty:      "Menampilkan 0 sampai 0 dari 0 entri",
        sInfoFiltered:   "(disaring dari _MAX_ entri keseluruhan)",
        sInfoPostFix:    "",
        sInfoThousands:  ".",
        sLengthMenu:     "Tampilkan _MENU_ entri",
        sLoadingRecords: "Sedang memuat...",
        sProcessing:     "Sedang memproses...",
        sSearch:         "Cari:",
        sZeroRecords:    "Tidak ditemukan data yang sesuai",
        oPaginate: {
            sFirst:    "Pertama",
            sLast:     "Terakhir",
            sNext:     "Selanjutnya",
            sPrevious: "Sebelumnya"
        },
        oAria: {
            sSortAscending:  ": aktifkan untuk mengurutkan kolom ke atas",
            sSortDescending: ": aktifkan untuk mengurutkan kolom ke bawah"
        }
    };
</script>
@stack('scripts')

</html>
