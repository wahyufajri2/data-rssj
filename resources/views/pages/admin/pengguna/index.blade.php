@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Manajemen Pengguna" />

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800 flex items-center justify-between"
                role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="font-medium mr-1">Sukses!</span> {{ session('success') }}
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800"><svg class="w-4 h-4"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg></button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show"
                class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800 flex items-center justify-between"
                role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                    </svg>
                    <span class="font-medium mr-1">Gagal!</span> {{ session('error') }}
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg></button>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show"
                class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                <div class="font-medium mb-1">Periksa kembali inputan Anda:</div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
                x-data="penggunaPage()" x-init="init()">

                {{-- Header --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <div class="relative w-full sm:w-48">
                                <select x-model="params.role"
                                    class="w-full h-10 pl-3 pr-8 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                                    <option value="">Semua Peran</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->nama_peran }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="relative w-full sm:w-72">
                                <input x-model.debounce.500ms="params.search" type="text"
                                    placeholder="Cari nama atau email..."
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

                        <button @click="openAddModal()"
                            class="inline-flex items-center justify-center font-medium gap-2 rounded-lg transition px-4 py-2.5 text-sm bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pengguna
                        </button>
                    </div>
                </div>

                {{-- Table Content --}}
                <div class="relative overflow-x-auto min-h-[300px]">
                    <div x-show="isLoading"
                        class="absolute inset-0 z-10 flex items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm transition-opacity">
                        <span class="font-medium text-sm text-brand-600">Memuat Data...</span>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-gray-800">
                                <th @click="sortBy('fullname')"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400 cursor-pointer hover:bg-gray-100 dark:hover:bg-white/[0.05] transition-colors select-none">
                                    <div class="flex items-center gap-1">
                                        Nama Lengkap
                                        <div class="flex flex-col">
                                            {{-- Ikon Panah Atas (Ascending) --}}
                                            <svg class="w-2 h-2"
                                                :class="params.sort_column === 'fullname' && params
                                                    .sort_direction === 'asc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 0L0 5H10L5 0Z" />
                                            </svg>
                                            {{-- Ikon Panah Bawah (Descending) --}}
                                            <svg class="w-2 h-2 mt-0.5"
                                                :class="params.sort_column === 'fullname' && params
                                                    .sort_direction === 'desc' ? 'text-gray-800 dark:text-white' :
                                                    'text-gray-300 dark:text-gray-600'"
                                                fill="currentColor" viewBox="0 0 10 5">
                                                <path d="M5 5L10 0H0L5 5Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Email</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Prodi</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
                                    Peran</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            {{-- Tampilan Saat Data Kosong (Empty State) --}}
                            <tr x-show="!isLoading && items.length === 0" x-cloak>
                                {{-- colspan="6" karena ada 6 kolom di thead (Nama, Email, Prodi, Peran, Status, Aksi) --}}
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        {{-- Ikon Sad Face (Wajah Sedih) --}}
                                        <svg class="w-12 h-12 mb-4 text-gray-400 dark:text-gray-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-base font-medium">Tidak ada data pengguna yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                            <template x-for="user in items" :key="user.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.03] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 font-bold text-xs">
                                                <span x-text="getInitials(user.fullname)"></span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white"
                                                    x-text="user.fullname"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400"
                                                    x-text="user.name"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" x-text="user.email">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                        x-text="user.prodi ? user.prodi.prodi : '-'"></td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400"
                                            x-text="user.peran ? user.peran.nama_peran : '-'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="user.active ?
                                                'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400' :
                                                'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400'">
                                            <span x-text="user.active ? 'Aktif' : 'Non-Aktif'"></span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        <div class="flex justify-end gap-2">
                                            <button @click="openDetailModal(user)"
                                                class="text-gray-500 hover:text-blue-600" title="Detail"><svg
                                                    class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg></button>
                                            <button @click="openEditModal(user)"
                                                class="text-gray-500 hover:text-brand-600" title="Edit"><svg
                                                    class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg></button>
                                            <button @click="openDeleteModal(user)"
                                                class="text-gray-500 hover:text-red-600" title="Hapus"><svg
                                                    class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg></button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex justify-between"
                    x-show="pagination.total > 0">
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

                {{-- ================= MODALS ================= --}}

                {{-- Modal Tambah / Edit --}}
                <div x-show="modalOpen" x-cloak
                    class="modal fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
                    @keydown.escape.window="closeModal()">
                    <div @click="closeModal()" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
                        x-transition.opacity></div>

                    <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10 max-w-[600px]"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                        <button @click="closeModal()"
                            class="absolute right-6 top-6 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        {{-- FORM STANDARD SUBMIT (Tanpa @submit.prevent) --}}
                        <form method="POST"
                            :action="isEditMode ? '{{ url('admin/pengguna') }}/' + form.id :
                                '{{ route('admin.pengguna.store') }}'">
                            @csrf
                            {{-- Method Spoofing untuk Edit --}}
                            <input type="hidden" name="_method" :value="isEditMode ? 'PUT' : 'POST'">

                            <h4 class="mb-6 text-lg font-medium text-gray-800 dark:text-white"
                                x-text="isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna'"></h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div><label
                                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Username</label><input
                                        name="name" x-model="form.name" type="text"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                        required></div>
                                <div><label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                        Lengkap</label><input name="fullname" x-model="form.fullname" type="text"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                        required></div>
                                <div class="sm:col-span-2"><label
                                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Email</label><input
                                        name="email" x-model="form.email" type="email"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                        required></div>
                                <div class="sm:col-span-2"><label
                                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Password
                                        <span x-show="isEditMode"
                                            class="text-xs text-gray-500">(Opsional)</span></label><input name="password"
                                        type="password"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                </div>
                                <div><label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">No.
                                        HP</label><input name="no_hp" x-model="form.no_hp" type="text"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                </div>

                                {{-- Peran --}}
                                <div>
                                    <label
                                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Peran</label>
                                    <select name="peran_id" x-model="form.peran_id" @change="checkProdiRequired()"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                        required>
                                        <option value="">Pilih Peran</option>
                                        @foreach ($formRoles as $role)
                                            <option value="{{ $role->id }}"
                                                data-name="{{ strtolower($role->nama_peran) }}">{{ $role->nama_peran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Prodi --}}
                                <div class="sm:col-span-2" x-show="isProdiRequired" x-transition>
                                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-400">Program
                                        Studi <span
                                            class="text-xs text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 px-1.5 py-0.5 rounded font-medium">Wajib</span></label>
                                    <select name="prodi_id" x-model="form.prodi_id"
                                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                        <option value="">Pilih Prodi</option>
                                        @foreach ($prodiList as $p)
                                            <option value="{{ $p->id_unitkerja }}">{{ $p->prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status Aktif --}}
                                <div
                                    class="sm:col-span-2 flex items-center justify-between p-4 border rounded-xl dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Status Aktif</span>

                                    {{-- Input hidden ini yang akan dikirim ke server --}}
                                    {{-- name="active" akan bernilai "1" atau "0" --}}
                                    <input type="hidden" name="active" :value="form.active ? 1 : 0">

                                    <button type="button" @click="form.active = !form.active"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-brand-600 focus:ring-offset-2"
                                        :class="form.active ? 'bg-brand-600' : 'bg-gray-200 dark:bg-gray-700'">
                                        <span
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"
                                            :class="form.active ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <button type="button" @click="closeModal()"
                                    class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">Batal</button>

                                {{-- Tombol Submit Biasa --}}
                                <button type="submit"
                                    class="px-4 py-2 text-sm text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Detail --}}
                <div x-show="detailModalOpen" x-cloak
                    class="modal fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
                    @keydown.escape.window="closeDetailModal()">
                    <div @click="closeDetailModal()"
                        class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]" x-transition.opacity></div>
                    <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10 max-w-[584px]"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <button @click="closeDetailModal()"
                            class="absolute right-6 top-6 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"><svg
                                class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg></button>
                        <div class="text-center mb-6">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-brand-100 text-brand-600 text-3xl font-bold dark:bg-brand-900/30 dark:text-brand-400 mb-4">
                                <span x-text="getInitials(detailUser.fullname)"></span>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="detailUser.fullname">
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400" x-text="detailUser.email"></p>
                        </div>
                        <div class="space-y-4 border-t border-gray-100 pt-4 dark:border-gray-800">
                            <div class="grid grid-cols-2 gap-4">
                                <div><span class="block text-xs text-gray-500">Username</span><span
                                        class="text-sm font-medium dark:text-white" x-text="detailUser.name"></span></div>
                                <div><span class="block text-xs text-gray-500">No. HP</span><span
                                        class="text-sm font-medium dark:text-white"
                                        x-text="detailUser.no_hp ?? '-'"></span></div>
                                <div><span class="block text-xs text-gray-500">Peran</span><span
                                        class="text-sm font-medium text-brand-600"
                                        x-text="detailUser.peran?.nama_peran ?? '-'"></span></div>
                                <div><span class="block text-xs text-gray-500">Prodi</span><span
                                        class="text-sm font-medium dark:text-white"
                                        x-text="detailUser.prodi?.prodi ?? '-'"></span></div>
                                <div><span class="block text-xs text-gray-500">Status</span><span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="detailUser.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"><span
                                            x-text="detailUser.active ? 'Aktif' : 'Non-Aktif'"></span></span></div>
                                <div><span class="block text-xs text-gray-500">Terdaftar Sejak</span><span
                                        class="text-sm font-medium dark:text-white"
                                        x-text="formatDate(detailUser.created_at)"></span></div>
                            </div>
                        </div>
                        <div class="mt-8"><button @click="closeDetailModal()"
                                class="w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">Tutup</button>
                        </div>
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
                        <h4 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Hapus Pengguna?</h4>
                        <p class="mb-8 text-sm text-gray-500 dark:text-gray-400">Yakin ingin menghapus <span
                                class="font-bold" x-text="form.fullname"></span>?</p>
                        <form method="POST" :action="'{{ url('admin/pengguna') }}/' + form.id">
                            @csrf @method('DELETE')
                            <div class="flex justify-center gap-3">
                                <button type="button" @click="closeModal()"
                                    class="px-4 py-2 border rounded-lg dark:text-white">Batal</button>
                                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg">Ya,
                                    Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function penggunaPage() {
            return {
                items: [],
                isLoading: false,
                params: {
                    search: '',
                    role: '',
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
                modalOpen: false,
                detailModalOpen: false,
                deleteModalOpen: false,
                isEditMode: false,
                isProdiRequired: false,

                // Form Model
                form: {
                    id: null,
                    name: '',
                    fullname: '',
                    email: '',
                    password: '',
                    no_hp: '',
                    peran_id: '',
                    prodi_id: '',
                    active: true
                },
                detailUser: {},

                init() {
                    this.fetchData();

                    this.$watch('params.role', () => {
                        this.params.page = 1;
                        this.fetchData();
                    });

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

                    // Cek Session Error dari Laravel (Optional: Log ke console jika perlu)
                    @if (session('error'))
                        console.error('Server Error:', "{{ session('error') }}");
                    @endif
                },

                sortBy(column) {
                    if (this.params.sort_column === column) {
                        // Jika kolom sama diklik lagi, balik arahnya
                        this.params.sort_direction = this.params.sort_direction === 'asc' ? 'desc' : 'asc';
                    } else {
                        // Jika kolom baru, set default ke ascending
                        this.params.sort_column = column;
                        this.params.sort_direction = 'asc';
                    }
                    this.fetchData(); // Ambil data ulang dengan parameter sort baru
                },

                async fetchData() {
                    this.isLoading = true;
                    const url =
                        `{{ route('admin.pengguna.get_data') }}?${new URLSearchParams(this.params).toString()}`;
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
                        console.error("Error:", error);
                    } finally {
                        this.isLoading = false;
                    }
                },

                nextPage() {
                    if (this.params.page < this.pagination.last_page) this.params.page++;
                },
                prevPage() {
                    if (this.params.page > 1) this.params.page--;
                },

                openAddModal() {
                    this.isEditMode = false;
                    this.resetForm();
                    this.modalOpen = true;
                },

                openEditModal(user) {
                    this.isEditMode = true;
                    this.form = {
                        id: user.id,
                        name: user.name,
                        fullname: user.fullname,
                        email: user.email,
                        password: '',
                        no_hp: user.no_hp,
                        peran_id: user.peran_id,
                        prodi_id: user.prodi_id,
                        active: Boolean(user.active) // Convert 1/0 to true/false
                    };
                    this.$nextTick(() => {
                        this.checkProdiRequired();
                    });
                    this.modalOpen = true;
                },

                openDetailModal(user) {
                    this.detailUser = user;
                    this.detailModalOpen = true;
                },
                openDeleteModal(user) {
                    this.form.id = user.id;
                    this.form.fullname = user.fullname;
                    this.deleteModalOpen = true;
                },
                closeModal() {
                    this.modalOpen = false;
                    this.deleteModalOpen = false;
                },
                closeDetailModal() {
                    this.detailModalOpen = false;
                },

                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        fullname: '',
                        email: '',
                        password: '',
                        no_hp: '',
                        peran_id: '',
                        prodi_id: '',
                        active: true
                    };
                    this.isProdiRequired = false;
                },

                checkProdiRequired() {
                    let select = document.querySelector('select[name="peran_id"]');
                    if (select) {
                        let selectedId = this.form.peran_id;
                        let option = Array.from(select.options).find(opt => opt.value == selectedId);
                        if (option) {
                            let roleName = option.getAttribute('data-name') || '';
                            this.isProdiRequired = ['verifikator', 'kaprodi', 'prodi'].some(k => roleName.includes(k));
                            return;
                        }
                    }
                    this.isProdiRequired = false;
                },

                getInitials(name) {
                    return name ? name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase() : '';
                },
                formatDate(d) {
                    return d ? new Date(d).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) : '-';
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
