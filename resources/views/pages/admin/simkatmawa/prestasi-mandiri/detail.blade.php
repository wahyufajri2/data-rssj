@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        {{-- Breadcrumb 4 Tingkat --}}
        <x-common.page-breadcrumb pageTitle="Detail Data" :breadcrumbs="[
            [
                'name' => 'SIMKATMAWA',
                'url' => route('admin.simkatmawa.index'),
            ],
            [
                'name' => 'Prestasi Mandiri',
                'url' => route('admin.simkatmawa.prestasimandiri'),
            ],
        ]" />

        <div x-data="detailPrestasiPage()" x-init="init()" class="space-y-5 sm:space-y-6">

            {{-- Kartu Ringkasan (Summary) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div
                    class="p-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Periode Tahun</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">2026</h3>
                </div>
                <div
                    class="p-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Data</p>
                    <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400">2,000</h3>
                </div>
                <div
                    class="p-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Berhasil Diunggah</p>
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">1,995</h3>
                </div>
                <div
                    class="p-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Gagal / Belum</p>
                    <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">5</h3>
                </div>
            </div>

            {{-- Container Tabel Utama --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

                {{-- Header Filter & Pencarian --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            {{-- Filter Status --}}
                            <div class="relative w-full sm:w-56">
                                <select x-model="params.status"
                                    class="w-full h-10 pl-3 pr-8 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                                    <option value="">Semua Status</option>
                                    <option value="Berhasil">Berhasil</option>
                                    <option value="Gagal">Gagal</option>
                                    <option value="Belum">Belum Terunggah</option>
                                </select>
                            </div>

                            {{-- Pencarian --}}
                            <div class="relative w-full sm:w-72">
                                <input x-model.debounce.500ms="params.search" type="text"
                                    placeholder="Cari nama, NIM, atau lomba..."
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

                        {{-- Tombol Unggah Semua (Sisa yang belum) --}}
                        <button
                            class="inline-flex items-center justify-center font-medium gap-2 rounded-lg transition px-4 py-2.5 text-sm bg-blue-600 text-white shadow-theme-xs hover:bg-blue-700 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Coba Ulang yang Gagal
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
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    No
                                </th>
                                <th @click="sortBy('nama')"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">Mahasiswa <div class="flex flex-col"><svg
                                                class="w-2 h-2"
                                                :class="params.sort_column === 'nama' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg><svg class="w-2 h-2 mt-0.5"
                                                :class="params.sort_column === 'nama' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg></div>
                                    </div>
                                </th>
                                <th @click="sortBy('prestasi')"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">Nama Kompetisi <div class="flex flex-col"><svg
                                                class="w-2 h-2"
                                                :class="params.sort_column === 'prestasi' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg><svg class="w-2 h-2 mt-0.5"
                                                :class="params.sort_column === 'prestasi' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg></div>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Tingkat / Kategori
                                </th>
                                <th @click="sortBy('status')"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">Status API <div class="flex flex-col"><svg
                                                class="w-2 h-2"
                                                :class="params.sort_column === 'status' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg><svg class="w-2 h-2 mt-0.5"
                                                :class="params.sort_column === 'status' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg></div>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            <tr x-show="!isLoading && items.length === 0" x-cloak>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mb-4 text-gray-400 dark:text-gray-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-base font-medium">Tidak ada rincian data ditemukan.</p>
                                    </div>
                                </td>
                            </tr>

                            <template x-for="(item, index) in items" :key="item.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-white"
                                        x-text="pagination.from + index">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white"
                                                x-text="item.nama"></span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400"
                                                x-text="item.nim"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white"
                                                x-text="item.prestasi"></span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400"
                                                x-text="item.jenis"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-700 dark:text-gray-300"
                                            x-text="item.tingkat"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1 items-start">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                                :class="{
                                                    'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400': item
                                                        .status === 'Berhasil',
                                                    'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400': item
                                                        .status === 'Gagal',
                                                    'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400': item
                                                        .status === 'Belum'
                                                }">
                                                <span
                                                    x-text="item.status === 'Belum' ? 'Belum Diunggah' : item.status"></span>
                                            </span>
                                            {{-- Tampilkan Pesan Error Jika Gagal --}}
                                            <span x-show="item.status === 'Gagal'"
                                                class="text-[10px] text-red-500 dark:text-red-400 max-w-[150px] truncate"
                                                title="Error: Dokumen tidak valid" x-text="item.error_msg"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" :disabled="item.status === 'Berhasil'"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                                            :class="item.status === 'Berhasil' ?
                                                'bg-gray-300 cursor-not-allowed dark:bg-gray-700' :
                                                'bg-brand-500 hover:bg-brand-600 focus:ring-brand-500'">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Unggah Satuan
                                        </button>
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
            Alpine.data('detailPrestasiPage', () => ({
                items: [],
                isLoading: false,
                params: {
                    search: '',
                    status: '',
                    sort_column: 'nama',
                    sort_direction: 'asc',
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
                    this.loadDummyData();

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

                loadDummyData() {
                    this.isLoading = true;
                    setTimeout(() => {
                        let allData = [{
                                id: 1,
                                nim: '210101001',
                                nama: 'Budi Santoso',
                                prestasi: 'Lomba Esai Nasional 2026',
                                jenis: 'Penalaran Akademik',
                                tingkat: 'Nasional',
                                status: 'Berhasil',
                                error_msg: ''
                            },
                            {
                                id: 2,
                                nim: '210101002',
                                nama: 'Siti Aminah',
                                prestasi: 'Kejuaraan Pencak Silat',
                                jenis: 'Olahraga',
                                tingkat: 'Provinsi',
                                status: 'Gagal',
                                error_msg: 'Format file sertifikat tidak didukung.'
                            },
                            {
                                id: 3,
                                nim: '210101003',
                                nama: 'Rudi Hermawan',
                                prestasi: 'Lomba Inovasi Teknologi',
                                jenis: 'Penalaran Akademik',
                                tingkat: 'Internasional',
                                status: 'Belum',
                                error_msg: ''
                            },
                            {
                                id: 4,
                                nim: '210101004',
                                nama: 'Andi Saputra',
                                prestasi: 'Musabaqah Tilawatil Quran',
                                jenis: 'Keagamaan',
                                tingkat: 'Nasional',
                                status: 'Berhasil',
                                error_msg: ''
                            },
                        ];

                        if (this.params.status !== '') {
                            allData = allData.filter(item => item.status === this.params
                                .status);
                        }

                        if (this.params.search.trim() !== '') {
                            let keyword = this.params.search.toLowerCase();
                            allData = allData.filter(item =>
                                item.nama.toLowerCase().includes(keyword) ||
                                item.nim.toLowerCase().includes(keyword) ||
                                item.prestasi.toLowerCase().includes(keyword)
                            );
                        }

                        let col = this.params.sort_column;
                        let dir = this.params.sort_direction === 'asc' ? 1 : -1;
                        allData.sort((a, b) => (a[col] > b[col] ? dir : (a[col] < b[col] ? -
                            dir : 0)));

                        this.items = allData;
                        this.pagination = {
                            from: allData.length > 0 ? 1 : 0,
                            to: allData.length,
                            total: allData.length,
                            last_page: 1,
                            current_page: 1
                        };

                        this.isLoading = false;
                    }, 400);
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
