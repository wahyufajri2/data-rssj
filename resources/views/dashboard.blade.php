@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
        <p class="text-gray-600 dark:text-gray-300">
            Anda login sebagai <span class="font-semibold text-emerald-600">{{ strtoupper(str_replace('_', ' ', auth()->user()->role)) }}</span>.
            @if(auth()->user()->isAdminRanting() && auth()->user()->ranting)
                <br>Wilayah: Ranting {{ auth()->user()->ranting->nama_ranting }}
            @endif
        </p>
    </div>

    <!-- Statistik Sederhana -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @if(auth()->user()->isSuperadmin())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Admin Ranting</h3>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_admin'] }}</span>
                <span class="text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
            </div>
            <a href="{{ route('superadmin.users.index') }}" class="mt-4 text-sm text-emerald-600 hover:text-emerald-700 block">Kelola Akun &rarr;</a>
        </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Data Pendataan Keluarga</h3>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_pendataan'] }}</span>
                <span class="text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </span>
            </div>
            <a href="{{ route('pendataan.index') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-700 block">Lihat Data &rarr;</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Data Kuesioner Mandiri</h3>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_kuesioner'] }}</span>
                <span class="text-yellow-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </span>
            </div>
            <a href="{{ route('kuesioner.index') }}" class="mt-4 text-sm text-yellow-600 hover:text-yellow-700 block">Lihat Kuesioner &rarr;</a>
        </div>
    </div>

    <!-- Area Grafik / Visualisasi Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Line Chart: Tren 6 Bulan Terakhir -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Tren Data Masuk (6 Bulan Terakhir)</h3>
            <div id="chart-tren" class="w-full h-80"></div>
        </div>

        <!-- Pie Chart: Status Kesehatan -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Proporsi Status Kesehatan (RSSJ)</h3>
            <div id="chart-kesehatan" class="w-full flex justify-center items-center h-80"></div>
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
        const pieSeries = @json($pieSeries);

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

        // 2. Pie Chart (Status Kesehatan)
        // Tangani kasus jika semua data 0 agar tidak glitch (tampilkan 1 data abu-abu "Kosong")
        const isPieEmpty = pieSeries.reduce((a, b) => a + b, 0) === 0;
        const finalPieSeries = isPieEmpty ? [1] : pieSeries;
        const finalPieLabels = isPieEmpty ? ['Belum ada data'] : pieLabels;
        const finalPieColors = isPieEmpty ? ['#d1d5db'] : ['#10b981', '#ef4444', '#f59e0b']; // Emerald (Sehat), Red (ODGJ), Amber (ODK)

        const pieOptions = {
            ...commonOptions,
            series: finalPieSeries,
            labels: finalPieLabels,
            chart: {
                ...commonOptions.chart,
                type: 'donut',
                height: 320
            },
            colors: finalPieColors,
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: !isPieEmpty,
                            name: { show: true },
                            value: { show: true }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
            tooltip: { enabled: !isPieEmpty, theme: isDarkMode ? 'dark' : 'light' }
        };
        const kesehatanChart = new ApexCharts(document.querySelector("#chart-kesehatan"), pieOptions);
        kesehatanChart.render();

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
                    kesehatanChart.updateOptions(updateObj);
                    wilayahChart.updateOptions(updateObj);
                }
            });
        });
        
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    });
</script>
@endsection
