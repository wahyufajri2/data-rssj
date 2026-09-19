@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="p-6">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Custom Select2 Tailwind/Dark mode styles */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border-color: #d1d5db !important;
            border-radius: 0.375rem !important;
            display: flex;
            align-items: center;
        }
        .dark .select2-container .select2-selection--single {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
        }
        .dark .select2-container .select2-selection--single .select2-selection__rendered {
            color: #fff !important;
        }
        .dark .select2-dropdown {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
        }
        .dark .select2-results__option {
            color: #d1d5db !important;
        }
        .dark .select2-results__option--highlighted[aria-selected] {
            background-color: #10b981 !important; /* emerald-500 */
        }
        .dark .select2-search input {
            background-color: #1f2937 !important;
            color: #fff !important;
            border-color: #4b5563 !important;
        }
    </style>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
        <p class="text-gray-600 dark:text-gray-300">
            Anda login sebagai <span class="font-semibold text-emerald-600">{{ strtoupper(str_replace('_', ' ', auth()->user()->role)) }}</span>.
            @if(auth()->user()->isAdminRanting() && auth()->user()->ranting)
                <br>Wilayah: Ranting {{ auth()->user()->ranting->nama_ranting }}
            @endif
        </p>
    </div>

    @if($isSuperadmin)
    <!-- Filter Ranting -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6 border border-gray-100 dark:border-gray-700">
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-4 w-full">
            <label for="ranting_filter" class="font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Filter Data Wilayah:</label>
            <div class="w-full max-w-sm">
                <select name="ranting_id" id="ranting_filter" class="w-full">
                    <option value="all" {{ $filterRantingId === null ? 'selected' : '' }}>Semua Ranting / Keseluruhan</option>
                    @foreach($rantings as $r)
                        <option value="{{ $r->id }}" {{ $filterRantingId == $r->id ? 'selected' : '' }}>Ranting {{ $r->nama_ranting }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    @endif

    <!-- Statistik Sederhana -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        @if($isSuperadmin)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Akun Admin Aktif</h3>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_admin'] }}</span>
                <span class="text-indigo-500 bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">Berdasarkan filter wilayah saat ini.</p>
        </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Orang yang Sudah Didata</h3>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_individu'] }}</span>
                <span class="text-emerald-500 bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">Total pendataan keluarga & kuesioner.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Keluarga yang Sudah Didata</h3>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_keluarga'] }}</span>
                <span class="text-blue-500 bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">Berdasarkan keunikan No. KK.</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-amber-500 hover:shadow-md transition-shadow lg:col-span-2">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-3">Rincian Status Kesehatan (Individu)</h3>
            <div class="grid grid-cols-3 gap-2">
                <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded-lg border border-red-100 dark:border-red-800/50 text-center">
                    <span class="block text-2xl font-bold text-red-700 dark:text-red-400">{{ $stats['individu_jiwa'] }}</span>
                    <span class="block text-xs font-medium text-red-600 dark:text-red-300 mt-1">Gangguan Jiwa</span>
                </div>
                <div class="bg-amber-50 dark:bg-amber-900/20 p-3 rounded-lg border border-amber-100 dark:border-amber-800/50 text-center">
                    <span class="block text-2xl font-bold text-amber-700 dark:text-amber-400">{{ $stats['individu_resiko'] }}</span>
                    <span class="block text-xs font-medium text-amber-600 dark:text-amber-300 mt-1">Resiko Psikososial</span>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-3 rounded-lg border border-emerald-100 dark:border-emerald-800/50 text-center">
                    <span class="block text-2xl font-bold text-emerald-700 dark:text-emerald-400">{{ $stats['individu_sehat'] }}</span>
                    <span class="block text-xs font-medium text-emerald-600 dark:text-emerald-300 mt-1">Sehat</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow lg:col-span-2">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-3">Rincian Status Kesehatan (Keluarga)</h3>
            <div class="grid grid-cols-3 gap-2">
                <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded-lg border border-red-100 dark:border-red-800/50 text-center">
                    <span class="block text-2xl font-bold text-red-700 dark:text-red-400">{{ $stats['keluarga_jiwa'] }}</span>
                    <span class="block text-xs font-medium text-red-600 dark:text-red-300 mt-1">Keluarga Jiwa</span>
                </div>
                <div class="bg-amber-50 dark:bg-amber-900/20 p-3 rounded-lg border border-amber-100 dark:border-amber-800/50 text-center">
                    <span class="block text-2xl font-bold text-amber-700 dark:text-amber-400">{{ $stats['keluarga_resiko'] }}</span>
                    <span class="block text-xs font-medium text-amber-600 dark:text-amber-300 mt-1">Keluarga Resiko</span>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-3 rounded-lg border border-emerald-100 dark:border-emerald-800/50 text-center">
                    <span class="block text-2xl font-bold text-emerald-700 dark:text-emerald-400">{{ $stats['keluarga_sehat'] }}</span>
                    <span class="block text-xs font-medium text-emerald-600 dark:text-emerald-300 mt-1">Keluarga Sehat</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Grafik / Visualisasi Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Line Chart: Tren 6 Bulan Terakhir -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Tren Data Masuk (6 Bulan Terakhir)</h3>
            <div id="chart-tren" class="w-full h-80"></div>
        </div>

        <!-- Pie Chart: Status Kesehatan Keluarga -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Status Kesehatan (Per Keluarga)</h3>
            <div id="chart-kesehatan-keluarga" class="w-full flex justify-center items-center h-80"></div>
        </div>

        <!-- Pie Chart: Status Kesehatan Individu -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Status Kesehatan (Per Individu)</h3>
            <div id="chart-kesehatan-individu" class="w-full flex justify-center items-center h-80"></div>
        </div>

        <!-- Bar Chart: Perbandingan Ranting / Dusun -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">{{ $barTitle }}</h3>
            <div id="chart-wilayah" class="w-full h-80"></div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Data dari Controller
        const months = @json(array_reverse($months));
        const pendataanTrend = @json(array_reverse($pendataanTrend));
        const kuesionerTrend = @json(array_reverse($kuesionerTrend));

        const pieLabels = @json($pieLabels);
        const pieSeriesIndividu = @json($pieSeriesIndividu);
        const pieSeriesKeluarga = @json($pieSeriesKeluarga);

        const barLabels = @json($barLabels);
        const barSeries = @json($barSeries);

        // Fungsi pendeteksi tema sistem / Tailwind (Dark Mode)
        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? '#9ca3af' : '#4b5563'; // Tailwind gray-400 : gray-600
        const gridColor = isDarkMode ? '#374151' : '#e5e7eb'; // Tailwind gray-700 : gray-200

        // Konfigurasi umum
        const commonOptions = {
            chart: {
                background: 'transparent',
                foreColor: textColor,
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false }
            },
            grid: { borderColor: gridColor },
            theme: { mode: isDarkMode ? 'dark' : 'light' },
            tooltip: { theme: isDarkMode ? 'dark' : 'light' }
        };

        // 1. Line Chart (Tren)
        const trenOptions = {
            ...commonOptions,
            series: [
                { name: 'Pendataan Keluarga', data: pendataanTrend },
                { name: 'Kuesioner Mandiri', data: kuesionerTrend }
            ],
            chart: {
                ...commonOptions.chart,
                type: 'area',
                height: 320,
                dropShadow: {
                    enabled: true,
                    top: 2,
                    left: 0,
                    blur: 4,
                    opacity: 0.1
                }
            },
            colors: ['#3b82f6', '#eab308'], // Blue, Yellow
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: months,
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            dataLabels: { enabled: false }
        };
        const trenChart = new ApexCharts(document.querySelector("#chart-tren"), trenOptions);
        trenChart.render();

        // 2. Pie Chart (Status Kesehatan Keluarga)
        const isPieKeluargaEmpty = pieSeriesKeluarga.reduce((a, b) => a + b, 0) === 0;
        const finalPieKeluargaSeries = isPieKeluargaEmpty ? [1] : pieSeriesKeluarga;
        const finalPieKeluargaLabels = isPieKeluargaEmpty ? ['Belum ada data'] : pieLabels;
        const finalPieKeluargaColors = isPieKeluargaEmpty ? ['#d1d5db'] : ['#10b981', '#f59e0b', '#ef4444']; // Emerald (Sehat), Amber (Resiko), Red (Jiwa)

        const pieKeluargaOptions = {
            ...commonOptions,
            series: finalPieKeluargaSeries,
            labels: finalPieKeluargaLabels,
            chart: {
                ...commonOptions.chart,
                type: 'donut',
                height: 320
            },
            colors: finalPieKeluargaColors,
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: !isPieKeluargaEmpty,
                            name: { show: true },
                            value: { show: true }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
            tooltip: { enabled: !isPieKeluargaEmpty, theme: isDarkMode ? 'dark' : 'light' }
        };
        const kesehatanKeluargaChart = new ApexCharts(document.querySelector("#chart-kesehatan-keluarga"), pieKeluargaOptions);
        kesehatanKeluargaChart.render();

        // 3. Pie Chart (Status Kesehatan Individu)
        const isPieIndividuEmpty = pieSeriesIndividu.reduce((a, b) => a + b, 0) === 0;
        const finalPieIndividuSeries = isPieIndividuEmpty ? [1] : pieSeriesIndividu;
        const finalPieIndividuLabels = isPieIndividuEmpty ? ['Belum ada data'] : pieLabels;
        const finalPieIndividuColors = isPieIndividuEmpty ? ['#d1d5db'] : ['#10b981', '#f59e0b', '#ef4444']; // Emerald (Sehat), Amber (Resiko), Red (Jiwa)

        const pieIndividuOptions = {
            ...commonOptions,
            series: finalPieIndividuSeries,
            labels: finalPieIndividuLabels,
            chart: {
                ...commonOptions.chart,
                type: 'donut',
                height: 320
            },
            colors: finalPieIndividuColors,
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: !isPieIndividuEmpty,
                            name: { show: true },
                            value: { show: true }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
            tooltip: { enabled: !isPieIndividuEmpty, theme: isDarkMode ? 'dark' : 'light' }
        };
        const kesehatanIndividuChart = new ApexCharts(document.querySelector("#chart-kesehatan-individu"), pieIndividuOptions);
        kesehatanIndividuChart.render();

        // 3. Bar Chart (Top Wilayah)
        const barOptions = {
            ...commonOptions,
            series: [{ name: 'Total Data', data: barSeries }],
            chart: {
                ...commonOptions.chart,
                type: 'bar',
                height: 320
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                    distributed: true // warna-warni tiap bar
                }
            },
            colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#14b8a6', '#f43f5e'],
            dataLabels: { enabled: true },
            xaxis: { categories: barLabels },
            legend: { show: false } // Sembunyikan legend karena sudah ada di axis Y
        };
        const wilayahChart = new ApexCharts(document.querySelector("#chart-wilayah"), barOptions);
        wilayahChart.render();

        // MutationObserver untuk mendeteksi perubahan tema (class 'dark' di elemen html)
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isNowDark = document.documentElement.classList.contains('dark');
                    const newTheme = isNowDark ? 'dark' : 'light';
                    const newTextColor = isNowDark ? '#9ca3af' : '#4b5563';
                    const newGridColor = isNowDark ? '#374151' : '#e5e7eb';
                    
                    const updateObj = {
                        theme: { mode: newTheme },
                        chart: { foreColor: newTextColor, background: 'transparent' },
                        grid: { borderColor: newGridColor },
                        tooltip: { theme: newTheme }
                    };
                    
                    trenChart.updateOptions(updateObj);
                    kesehatanKeluargaChart.updateOptions(updateObj);
                    kesehatanIndividuChart.updateOptions(updateObj);
                    wilayahChart.updateOptions(updateObj);
                }
            });
        });
        
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    });
</script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('#ranting_filter').length > 0) {
            $('#ranting_filter').select2({
                width: '100%',
                placeholder: 'Cari wilayah...'
            }).on('change', function() {
                $(this).closest('form').submit();
            });
        }
    });
</script>
@endpush
@endsection
