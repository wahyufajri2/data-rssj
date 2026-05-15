@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Semua Pengajuan" />

        <div class="space-y-5 sm:space-y-6">
            {{-- Main Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
                x-data="dataTable()" x-init="init()">

                {{-- Filter Header --}}
                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 items-end">

                        {{-- Filter: Jenis Pengajuan --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis</label>
                            <div class="relative z-20 bg-transparent">
                                <select x-model="params.jenis"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="">Semua Jenis</option>
                                    @foreach ($jenisPengajuan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Filter: Status --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                            <div class="relative z-20 bg-transparent">
                                <select x-model="params.status"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="">Semua Status</option>
                                    @foreach ($status as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_status }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Filter: Prodi --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Prodi</label>
                            <div class="relative z-20 bg-transparent">
                                <select x-model="params.prodi"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="">Semua Prodi</option>
                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->id_unitkerja }}">{{ $item->prodi }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Filter: Periode --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Periode</label>
                            <div class="relative z-20 bg-transparent">
                                <select x-model="params.periode"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="">Semua Periode</option>
                                    @foreach ($periode as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_periode }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Hapus Filter --}}
                        <div>
                            <button @click="resetFilters()"
                                class="flex w-full h-11 items-center justify-center gap-2 rounded-lg text-sm font-medium transition-colors bg-red-200 text-gray-700 hover:text-red-50 hover:bg-red-700 dark:bg-red-800 dark:text-white dark:hover:bg-red-600">
                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.0857 3.6975H12.0086C11.8596 2.15006 10.551 0.9375 8.99996 0.9375C7.44893 0.9375 6.14028 2.15006 5.99131 3.6975H2.91425C2.47937 3.6975 2.12681 4.05006 2.12681 4.48494C2.12681 4.91981 2.47937 5.27237 2.91425 5.27237H15.0857C15.5205 5.27237 15.8731 4.91981 15.8731 4.48494C15.8731 4.05006 15.5205 3.6975 15.0857 3.6975ZM8.99996 2.51237C9.6429 2.51237 10.187 2.94956 10.3857 3.54H7.61425C7.8129 2.94956 8.35703 2.51237 8.99996 2.51237ZM3.86877 6.68988C3.8294 6.25681 3.44759 5.93888 3.01453 5.97825C2.58146 6.01763 2.26353 6.39944 2.3029 6.8325L3.13093 15.9403C3.2185 16.9037 4.02528 17.6398 4.99293 17.6398H13.0071C13.9748 17.6398 14.7815 16.9037 14.8691 15.9403L15.6971 6.8325C15.7365 6.39944 15.4185 6.01763 14.9855 5.97825C14.5524 5.93888 14.1706 6.25681 14.1312 6.68988L13.3229 15.5801C13.2985 15.8483 13.0739 16.0536 12.8043 16.0536H5.19574C4.92612 16.0536 4.70153 15.8483 4.67715 15.5801L3.86877 6.68988Z" />
                                </svg>
                                Hapus Filter
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Table Content --}}
                <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6 relative">

                    {{-- Loading Overlay --}}
                    <div x-show="isLoading"
                        class="absolute inset-0 z-50 flex items-center justify-center bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm rounded-b-2xl">
                        <div class="flex items-center gap-2 text-brand-500">
                            <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="font-medium">Memuat Data...</span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        {{-- Controls --}}
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-gray-500 dark:text-gray-400">Show</span>
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
                                <span class="text-gray-500 dark:text-gray-400">entries</span>
                            </div>

                            <div class="relative">
                                <button class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                            fill=""></path>
                                    </svg>
                                </button>
                                <input x-model.debounce.500ms="params.search" type="text" placeholder="Cari data..."
                                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="max-w-full overflow-x-auto">
                            <table class="w-full min-w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        @foreach (['judul' => 'Judul', 'nim' => 'NIM', 'prodi' => 'Prodi', 'jenis' => 'Jenis', 'status' => 'Status', 'created_at' => 'Tanggal', 'periode' => 'Periode'] as $key => $label)
                                            <th class="px-4 py-3 text-sm font-medium text-gray-500 border-b border-gray-100 bg-gray-50 dark:bg-white/[0.03] dark:border-gray-800 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                                                @click="sortBy('{{ $key }}')">
                                                <div class="flex items-center gap-1">
                                                    <span>{{ $label }}</span>
                                                    <div class="flex flex-col gap-0.5">
                                                        <svg class="w-2 h-2 fill-current"
                                                            :class="(params.sort_column === '{{ $key }}' && params
                                                                .sort_direction === 'asc') ?
                                                            'text-gray-800 dark:text-white' :
                                                            'text-gray-300 dark:text-gray-600'"
                                                            viewBox="0 0 10 5">
                                                            <path d="M5 0L0 5H10L5 0Z" />
                                                        </svg>
                                                        <svg class="w-2 h-2 fill-current"
                                                            :class="(params.sort_column === '{{ $key }}' && params
                                                                .sort_direction === 'desc') ?
                                                            'text-gray-800 dark:text-white' :
                                                            'text-gray-300 dark:text-gray-600'"
                                                            viewBox="0 0 10 5">
                                                            <path d="M5 5L10 0H0L5 5Z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </th>
                                        @endforeach
                                        <th
                                            class="px-4 py-3 text-sm font-medium text-gray-500 border-b border-gray-100 bg-gray-50 dark:bg-white/[0.03] dark:border-gray-800 dark:text-gray-400">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="item in items" :key="item.id">
                                        <tr
                                            class="border-b border-gray-100 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.03] transition-colors">
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300" x-text="item.judul">
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300" x-text="item.nim"></td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300" x-text="item.prodi">
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300" x-text="item.jenis">
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                                    :class="{
                                                        'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400': item
                                                            .status == 2, // Sesuaikan ID status di DB
                                                        'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400': item
                                                            .status == 4, // Sesuaikan ID status di DB
                                                        'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400': item
                                                            .status == 1 // Sesuaikan ID status di DB
                                                    }"
                                                    x-text="getStatusName(item.status)"></span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300"
                                                x-text="formatDate(item.created_at)"></td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300" x-text="item.periode">
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button
                                                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>

                                    {{-- Empty State --}}
                                    <tr x-show="!isLoading && items.length === 0">
                                        <td colspan="8"
                                            class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-2 text-gray-300 dark:text-gray-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <p>Tidak ada data pengajuan yang ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Footer --}}
                        <div class="flex flex-col gap-4 border-t border-gray-100 pt-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between"
                            x-show="pagination.total > 0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan <span x-text="pagination.from"></span> sampai <span
                                    x-text="pagination.to"></span> dari <span x-text="pagination.total"></span> data
                            </p>
                            <div class="flex items-center gap-2">
                                <button @click="prevPage" :disabled="params.page === 1"
                                    class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                                    Previous
                                </button>
                                <button @click="nextPage" :disabled="params.page === pagination.last_page"
                                    class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function dataTable() {
            return {
                items: [],
                isLoading: false,
                params: {
                    search: '',
                    jenis: '',
                    status: '',
                    prodi: '',
                    periode: '',
                    page: 1,
                    per_page: 10,
                    sort_column: 'created_at',
                    sort_direction: 'desc'
                },
                pagination: {
                    from: 0,
                    to: 0,
                    total: 0,
                    last_page: 1
                },
                // Mapping ID Status ke Nama (Opsional jika API sudah kirim nama)
                statusMap: {
                    1: 'Pending',
                    2: 'Disetujui',
                    4: 'Ditolak',
                    5: 'Revisi',
                    7: 'Dibatalkan'
                },
                init() {
                    this.fetchData();
                    this.$watch('params.search', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });
                    this.$watch('params.jenis', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });
                    this.$watch('params.status', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });
                    this.$watch('params.prodi', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });
                    this.$watch('params.periode', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });
                    this.$watch('params.per_page', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });
                    this.$watch('params.page', () => {
                        this.fetchData();
                    });
                },
                async fetchData() {
                    this.isLoading = true;
                    // Menggunakan Route Laravel yang sudah diperbaiki
                    const endpoint =
                        `{{ route('admin.pengajuan.get_data') }}?${new URLSearchParams(this.params).toString()}`;

                    try {
                        const response = await fetch(endpoint);
                        const result = await response.json();

                        this.items = result.data;
                        this.pagination = {
                            from: result.from ?? 0,
                            to: result.to ?? 0,
                            total: result.total ?? 0,
                            last_page: result.last_page ?? 1
                        };
                    } catch (error) {
                        console.error('Error fetching data:', error);
                    } finally {
                        this.isLoading = false;
                    }
                },
                sortBy(column) {
                    if (this.params.sort_column === column) {
                        this.params.sort_direction = this.params.sort_direction === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.params.sort_column = column;
                        this.params.sort_direction = 'asc';
                    }
                    this.fetchData();
                },
                nextPage() {
                    if (this.params.page < this.pagination.last_page) this.params.page++;
                },
                prevPage() {
                    if (this.params.page > 1) this.params.page--;
                },
                resetFilters() {
                    this.params.search = '';
                    this.params.jenis = '';
                    this.params.status = '';
                    this.params.prodi = '';
                    this.params.periode = '';
                    this.params.page = 1;
                },
                // Helper Format Tanggal
                formatDate(dateString) {
                    if (!dateString) return '-';
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    return new Date(dateString).toLocaleDateString('id-ID', options);
                },
                // Helper Get Status Name (Jika API return ID)
                getStatusName(statusId) {
                    // Jika API sudah return string, langsung return statusId
                    // Jika return ID, gunakan mapping ini:
                    return this.statusMap[statusId] || statusId;
                }
            }
        }
    </script>
@endsection
