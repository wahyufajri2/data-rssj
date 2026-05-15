@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        {{-- Breadcrumb 3 Tingkat --}}
        <x-common.page-breadcrumb pageTitle="Prestasi Mandiri" :breadcrumbs="[
            [
                'name' => 'SIMKATMAWA',
                'url' => url('admin/simkatmawa'),
            ],
        ]" />

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
                x-data="prestasiMandiriPage()" x-init="init()">

                {{-- Header Filter & Pencarian --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            {{-- Filter Status --}}
                            <div class="relative w-full sm:w-56">
                                <select x-model="params.status"
                                    class="w-full h-10 pl-3 pr-8 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                                    <option value="">Semua Status</option>
                                    {{-- Value disamakan dengan teks status agar mudah difilter di JS --}}
                                    <option value="Belum Terunggah">Belum Terunggah</option>
                                    <option value="Unggah belum selesai">Unggah belum selesai</option>
                                    <option value="Unggah selesai">Unggah selesai</option>
                                </select>
                            </div>

                            {{-- Pencarian --}}
                            <div class="relative w-full sm:w-72">
                                <input x-model.debounce.500ms="params.search" type="text"
                                    placeholder="Cari tahun atau data..."
                                    class="w-full h-10 pl-10 pr-4 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Tarik Data --}}
                        <button
                            class="inline-flex items-center justify-center font-medium gap-2 rounded-lg transition px-4 py-2.5 text-sm bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Sinkronisasi Data
                        </button>
                    </div>
                </div>

                {{-- Table Content --}}
                <div class="relative overflow-x-auto min-h-[300px]">
                    <div x-show="isLoading"
                        class="absolute inset-0 z-10 flex items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm transition-opacity">
                        <span class="font-medium text-sm text-brand-600 dark:text-brand-400">Memuat Data...</span>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-gray-800">
                                <th
                                    class="px-6 py-5 text-sm font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    No
                                </th>
                                <th @click="sortBy('tahun')"
                                    class="px-6 py-5 text-sm font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">
                                        Tahun
                                        <div class="flex flex-col">
                                            <svg class="w-2.5 h-2.5"
                                                :class="params.sort_column === 'tahun' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg>
                                            <svg class="w-2.5 h-2.5 mt-0.5"
                                                :class="params.sort_column === 'tahun' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </th>
                                <th @click="sortBy('jumlah_data')"
                                    class="px-6 py-5 text-sm font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">
                                        Jumlah data
                                        <div class="flex flex-col">
                                            <svg class="w-2.5 h-2.5"
                                                :class="params.sort_column === 'jumlah_data' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg>
                                            <svg class="w-2.5 h-2.5 mt-0.5"
                                                :class="params.sort_column === 'jumlah_data' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </th>
                                <th @click="sortBy('status')"
                                    class="px-6 py-5 text-sm font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">
                                        Status
                                        <div class="flex flex-col">
                                            <svg class="w-2.5 h-2.5"
                                                :class="params.sort_column === 'status' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg>
                                            <svg class="w-2.5 h-2.5 mt-0.5"
                                                :class="params.sort_column === 'status' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-5 text-sm font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            {{-- Tampilan Saat Data Kosong (Empty State) --}}
                            <tr x-show="!isLoading && items.length === 0" x-cloak>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mb-4 text-gray-400 dark:text-gray-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-base font-medium">Tidak ada data prestasi yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>

                            {{-- Loop Data dari Alpine --}}
                            <template x-for="(item, index) in items" :key="item.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-6 text-base font-semibold text-gray-800 dark:text-white"
                                        x-text="pagination.from + index">
                                    </td>
                                    <td class="px-6 py-6 text-xl font-bold text-gray-800 dark:text-white"
                                        x-text="item.tahun">
                                    </td>
                                    <td class="px-6 py-6 text-lg font-semibold text-gray-800 dark:text-white"
                                        x-text="item.jumlah_data + ' data'">
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                                            :class="{
                                                'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400': item
                                                    .status === 'Belum Terunggah',
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400': item
                                                    .status === 'Unggah belum selesai',
                                                'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400': item
                                                    .status === 'Unggah selesai'
                                            }">
                                            <span x-text="item.status"></span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-3">
                                            {{-- Tombol Unggah Semua --}}
                                            <a href="#"
                                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                Unggah semua
                                            </a>

                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('admin.simkatmawa.prestasimandiri.detail') }}"
                                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex justify-between"
                    x-show="pagination.total > 0" x-cloak>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Show</span>
                        <div class="relative z-20 bg-transparent">
                            <select x-model="params.per_page"
                                class="w-full py-2 pl-3 pr-8 text-sm text-gray-800 bg-transparent border border-gray-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                            </select>
                            <span
                                class="absolute z-30 text-gray-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-gray-400">
                                <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16"
                                    fill="none">
                                    <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke=""
                                        stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">entries</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Menampilkan <span x-text="pagination.from"></span> - <span x-text="pagination.to"></span> dari
                            <span x-text="pagination.total"></span> data
                        </span>
                        <div class="flex gap-1">
                            <button @click="prevPage" :disabled="params.page === 1"
                                class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Prev
                            </button>
                            <button @click="nextPage" :disabled="params.page === pagination.last_page"
                                class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Next
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('prestasiMandiriPage', () => ({
                items: [],
                isLoading: false,
                params: {
                    search: '',
                    status: '',
                    sort_column: 'tahun',
                    sort_direction: 'desc',
                    page: 1,
                    per_page: 10
                },
                pagination: {
                    from: 0,
                    to: 0,
                    total: 0,
                    last_page: 1,
                    current_page: 1
                },

                init() {
                    // Gunakan Data Dummy untuk simulasi Frontend
                    this.loadDummyData();

                    // Mengawasi perubahan parameter untuk memicu fungsi data lokal
                    this.$watch('params.status', () => {
                        this.params.page = 1;
                        this.loadDummyData();
                    });
                    this.$watch('params.search', () => {
                        this.params.page = 1;
                        this.loadDummyData();
                    });
                    this.$watch('params.per_page', () => {
                        this.params.page = 1;
                        this.loadDummyData();
                    });
                    this.$watch('params.page', () => {
                        this.loadDummyData();
                    });
                },

                sortBy(column) {
                    if (this.params.sort_column === column) {
                        this.params.sort_direction = this.params.sort_direction === 'asc' ? 'desc' :
                            'asc';
                    } else {
                        this.params.sort_column = column;
                        this.params.sort_direction = 'asc';
                    }
                    this.loadDummyData();
                },

                // Fungsi API sebenarnya (Bisa Anda gunakan saat Controller sudah siap)
                async fetchData() {
                    this.isLoading = true;
                    const url =
                        `/admin/simkatmawa/prestasi-mandiri/get_data?${new URLSearchParams(this.params).toString()}`;
                    try {
                        const response = await fetch(url);
                        const result = await response.json();
                        this.items = result.data;
                        this.pagination = {
                            from: result.from ?? 0,
                            to: result.to ?? 0,
                            total: result.total ?? 0,
                            last_page: result.last_page ?? 1,
                            current_page: result.current_page ?? 1
                        };
                    } catch (error) {
                        console.error("Error fetching data:", error);
                    } finally {
                        this.isLoading = false;
                    }
                },

                // Fungsi Dummy Data yang sudah diimprovisasi agar Filter & Search bekerja
                loadDummyData() {
                    this.isLoading = true;
                    setTimeout(() => {
                        // 1. Data Mentah
                        let allData = [{
                                id: 1,
                                tahun: 2026,
                                jumlah_data: 2000,
                                status: 'Belum Terunggah'
                            },
                            {
                                id: 2,
                                tahun: 2025,
                                jumlah_data: 1500,
                                status: 'Unggah belum selesai'
                            },
                            {
                                id: 3,
                                tahun: 2024,
                                jumlah_data: 1750,
                                status: 'Unggah selesai'
                            }
                        ];

                        // 2. Terapkan Filter Status
                        if (this.params.status !== '') {
                            allData = allData.filter(item => item.status === this.params
                                .status);
                        }

                        // 3. Terapkan Pencarian (Search)
                        if (this.params.search.trim() !== '') {
                            let keyword = this.params.search.toLowerCase();
                            allData = allData.filter(item =>
                                item.tahun.toString().includes(keyword) ||
                                item.jumlah_data.toString().includes(keyword) ||
                                item.status.toLowerCase().includes(keyword)
                            );
                        }

                        // 4. Terapkan Sorting (ASC/DESC)
                        let col = this.params.sort_column;
                        let dir = this.params.sort_direction === 'asc' ? 1 : -1;
                        allData.sort((a, b) => {
                            if (a[col] > b[col]) return dir;
                            if (a[col] < b[col]) return -dir;
                            return 0;
                        });

                        // 5. Update State
                        this.items = allData;
                        this.pagination = {
                            from: allData.length > 0 ? 1 : 0,
                            to: allData.length,
                            total: allData.length,
                            last_page: 1,
                            current_page: 1
                        };

                        this.isLoading = false;
                    }, 400); // Simulasi delay jaringan 400ms
                },

                nextPage() {
                    if (this.params.page < this.pagination.last_page) this.params.page++;
                },
                prevPage() {
                    if (this.params.page > 1) this.params.page--;
                }
            }));
        });
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
