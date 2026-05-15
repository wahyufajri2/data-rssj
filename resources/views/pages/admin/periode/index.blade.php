@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Periode Pengajuan" />

        <div class="space-y-5 sm:space-y-6">

            {{-- Main Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
                x-data="periodePage()" x-init="init()">

                {{-- Header: Pencarian & Tombol Tambah --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        {{-- Search Input --}}
                        <div class="relative w-full sm:w-72">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input x-model.debounce.500ms="params.search" type="text" placeholder="Cari periode..."
                                class="w-full h-10 pl-10 pr-4 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>

                        {{-- Tombol Tambah Periode --}}
                        <button @click="openAddModal()"
                            class="inline-flex items-center justify-center font-medium gap-2 rounded-lg transition px-4 py-2.5 text-sm bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 disabled:bg-brand-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Periode
                        </button>
                    </div>
                </div>

                {{-- Table Content --}}
                <div class="relative overflow-x-auto min-h-[300px]"> {{-- Min height agar loading terlihat enak --}}

                    {{-- Loading Overlay --}}
                    <div x-show="isLoading"
                        class="absolute inset-0 z-10 flex items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm transition-opacity">
                        <div class="flex items-center gap-2 text-brand-600 dark:text-brand-400">
                            <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Memuat Data...</span>
                        </div>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-gray-800">
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Nama Periode</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Tahun Ajaran</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Waktu Mulai</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Waktu Selesai</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <template x-for="item in items" :key="item.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.03] transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="item.nama_periode"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                        x-text="item.tahun_ajaran"></td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="item.is_active ?
                                                'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400' :
                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'">
                                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full"
                                                :class="item.is_active ? 'bg-green-500' : 'bg-gray-500'"></span>
                                            <span x-text="item.is_active ? 'Aktif' : 'Non-Aktif'"></span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                        x-text="formatDateDisplay(item.waktu_mulai)"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                        x-text="formatDateDisplay(item.waktu_selesai)"></td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        <div class="flex justify-end gap-2">
                                            <button @click="openEditModal(item)"
                                                class="text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button @click="openDeleteModal(item)"
                                                class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            {{-- Empty State --}}
                            <tr x-show="!isLoading && items.length === 0">
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-2 text-gray-300 dark:text-gray-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <p>Tidak ada data periode yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Controls --}}
                <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                    x-show="pagination.total > 0">

                    {{-- Per Page Dropdown --}}
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

                    {{-- Info & Navigation --}}
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

                {{-- ================= MODALS ================= --}}

                {{-- Modal Tambah / Edit --}}
                <div x-show="modalOpen" x-cloak
                    class="modal fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
                    @keydown.escape.window="closeModal()">
                    <div @click="closeModal()" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
                        x-transition.opacity></div>

                    <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10 max-w-[584px]"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                        <button @click="closeModal()"
                            class="absolute right-6 top-6 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <form @submit.prevent="saveData">
                            <h4 class="mb-6 text-lg font-medium text-gray-800 dark:text-white/90"
                                x-text="isEditMode ? 'Edit Periode' : 'Tambah Periode'"></h4>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                        Periode</label>
                                    <input x-model="form.nama_periode" type="text"
                                        class="w-full px-4 py-2.5 text-sm border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-brand-500 focus:border-brand-500">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Tahun
                                        Ajaran</label>
                                    <input x-model="form.tahun_ajaran" type="text"
                                        class="w-full px-4 py-2.5 text-sm border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-brand-500 focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Waktu
                                        Mulai</label>
                                    <input x-model="form.waktu_mulai" type="datetime-local" step="1"
                                        class="w-full px-4 py-2.5 text-sm border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-brand-500 focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Waktu
                                        Selesai</label>
                                    <input x-model="form.waktu_selesai" type="datetime-local" step="1"
                                        class="w-full px-4 py-2.5 text-sm border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-brand-500 focus:border-brand-500">
                                </div>
                                <div
                                    class="sm:col-span-2 flex items-center justify-between p-4 border rounded-xl dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Status Aktif</span>
                                    <button @click="form.is_active = !form.is_active" type="button"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-brand-600 focus:ring-offset-2"
                                        :class="form.is_active ? 'bg-brand-600' : 'bg-gray-200 dark:bg-gray-700'">
                                        <span
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"
                                            :class="form.is_active ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <button @click="closeModal()" type="button"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:border-gray-600">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Hapus --}}
                <div x-show="deleteModalOpen" x-cloak
                    class="modal fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
                    @keydown.escape.window="closeModal()">
                    <div @click="closeModal()" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
                        x-transition.opacity></div>
                    <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10 max-w-[400px] text-center"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-red-100 rounded-full dark:bg-red-900/30">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h4 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Hapus Periode?</h4>
                        <p class="mb-8 text-sm text-gray-500 dark:text-gray-400">Yakin ingin menghapus <span
                                class="font-bold" x-text="form.nama_periode"></span>?</p>
                        <div class="flex justify-center gap-3">
                            <button @click="closeModal()" type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:border-gray-600">Batal</button>
                            <button @click="deleteData()" type="button"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Ya,
                                Hapus</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function periodePage() {
            return {
                // State Data
                items: [],
                isLoading: false,

                // Parameter Request ke Server
                params: {
                    search: '',
                    page: 1,
                    per_page: 10,
                    sort_column: 'created_at',
                    sort_direction: 'desc'
                },

                // State Pagination (Dari Server Laravel)
                pagination: {
                    from: 0,
                    to: 0,
                    total: 0,
                    last_page: 1,
                    current_page: 1
                },

                // State Modal
                modalOpen: false,
                deleteModalOpen: false,
                isEditMode: false,

                // Form Model
                form: {
                    id: null,
                    nama_periode: '',
                    tahun_ajaran: '',
                    waktu_mulai: '',
                    waktu_selesai: '',
                    is_active: false
                },

                init() {
                    this.fetchData();

                    // Watchers: Jika filter berubah, reset halaman dan ambil data baru
                    this.$watch('params.search', () => {
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

                    // Style Overflow Body saat Modal Terbuka
                    this.$watch('modalOpen', val => document.body.style.overflow = val ? 'hidden' : 'unset');
                    this.$watch('deleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : 'unset');
                },

                // --- FUNGSI UTAMA FETCH DATA ---
                async fetchData() {
                    this.isLoading = true;

                    // Build Query String dari params
                    const queryString = new URLSearchParams(this.params).toString();
                    const url = `{{ route('admin.periode.get_data') }}?${queryString}`;

                    try {
                        const response = await fetch(url);
                        const result = await response.json();

                        // Map Response Laravel Paginate ke State Alpine
                        this.items = result.data;
                        this.pagination = {
                            from: result.from ?? 0,
                            to: result.to ?? 0,
                            total: result.total ?? 0,
                            last_page: result.last_page ?? 1,
                            current_page: result.current_page ?? 1
                        };
                    } catch (error) {
                        console.error("Gagal mengambil data:", error);
                    } finally {
                        this.isLoading = false;
                    }
                },

                // --- HELPER NAVIGASI HALAMAN ---
                nextPage() {
                    if (this.params.page < this.pagination.last_page) {
                        this.params.page++;
                    }
                },
                prevPage() {
                    if (this.params.page > 1) {
                        this.params.page--;
                    }
                },

                // --- HELPER SORTING ---
                sortBy(column) {
                    if (this.params.sort_column === column) {
                        this.params.sort_direction = this.params.sort_direction === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.params.sort_column = column;
                        this.params.sort_direction = 'asc';
                    }
                    this.fetchData();
                },

                // --- MANAJEMEN MODAL ---
                openAddModal() {
                    this.isEditMode = false;
                    this.resetForm();
                    this.modalOpen = true;
                },

                openEditModal(item) {
                    this.isEditMode = true;
                    // Copy data item ke form
                    this.form = {
                        id: item.id,
                        nama_periode: item.nama_periode,
                        tahun_ajaran: item.tahun_ajaran,
                        // Konversi format tanggal DB (Y-m-d H:i:s) ke input datetime-local (Y-m-dTH:i)
                        waktu_mulai: this.formatDateForInput(item.waktu_mulai),
                        waktu_selesai: this.formatDateForInput(item.waktu_selesai),
                        is_active: Boolean(item.is_active)
                    };
                    this.modalOpen = true;
                },

                openDeleteModal(item) {
                    this.form.id = item.id;
                    this.form.nama_periode = item.nama_periode; // Untuk display nama di modal hapus
                    this.deleteModalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                    this.deleteModalOpen = false;
                },

                resetForm() {
                    this.form = {
                        id: null,
                        nama_periode: '',
                        tahun_ajaran: '',
                        waktu_mulai: '',
                        waktu_selesai: '',
                        is_active: false
                    };
                },

                // --- FORMATTER ---
                // Mengubah format DB "2024-01-01 10:00:00" menjadi "2024-01-01T10:00" untuk input HTML
                formatDateForInput(dateString) {
                    if (!dateString) return '';
                    return dateString.replace(' ', 'T').slice(0, 16);
                },

                // Mengubah format DB ke format Indonesia yang enak dibaca
                formatDateDisplay(dateString) {
                    if (!dateString) return '-';
                    const date = new Date(dateString);
                    return new Intl.DateTimeFormat('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }).format(date);
                },

                // --- LOGIKA SIMPAN & HAPUS (Placeholder - Sambungkan ke API Create/Update/Delete) ---
                saveData() {
                    console.log("Data yang akan dikirim:", this.form);
                    // Di sini nanti Anda tambahkan logika fetch POST/PUT ke Controller
                    alert("Logika simpan belum diimplementasikan di Backend.");
                    this.closeModal();
                    this.fetchData();
                },

                deleteData() {
                    console.log("Menghapus ID:", this.form.id);
                    // Di sini nanti Anda tambahkan logika fetch DELETE ke Controller
                    alert("Logika hapus belum diimplementasikan di Backend.");
                    this.closeModal();
                    this.fetchData();
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
