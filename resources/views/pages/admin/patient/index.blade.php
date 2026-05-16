@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <x-common.page-breadcrumb pageTitle="Data Pasien" />

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white/90">
                    Daftar Pasien Terdaftar
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-tl-lg">No</th>
                            <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-3">Nomor HP</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3 text-center">Tgl Daftar</th>
                            <th scope="col" class="px-6 py-3 text-center rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $index => $patient)
                            <tr
                                class="border-b bg-white dark:border-gray-800 dark:bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $patients->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white/90">
                                    {{ $patient->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $patient->no_hp }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $patient->email ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $patient->created_at->format('d M Y') }}
                                </td>

                                {{-- State Alpine.js untuk Modal di setiap baris --}}
                                <td class="px-6 py-4 text-center" x-data="{ viewModal: false, editModal: false }">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Lihat Detail --}}
                                        <button @click="viewModal = true" type="button"
                                            class="inline-flex items-center justify-center rounded-lg bg-blue-50 p-2 text-blue-500 transition-colors hover:bg-blue-100 hover:text-blue-700 dark:bg-blue-500/10 dark:hover:bg-blue-500/20"
                                            title="Lihat Detail Pasien">
                                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        {{-- Tombol Edit --}}
                                        <button @click="editModal = true" type="button"
                                            class="inline-flex items-center justify-center rounded-lg bg-amber-50 p-2 text-amber-500 transition-colors hover:bg-amber-100 hover:text-amber-700 dark:bg-amber-500/10 dark:hover:bg-amber-500/20"
                                            title="Edit Data Pasien">
                                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- ========================================== --}}
                                    {{-- 1. MODAL LIHAT DETAIL PASIEN --}}
                                    {{-- ========================================== --}}
                                    <template x-teleport="body">
                                        <div x-show="viewModal" style="display: none;"
                                            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 p-4 backdrop-blur-sm"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                            <div @click.away="viewModal = false"
                                                class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                                                <div
                                                    class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100 dark:border-gray-800">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail
                                                        Pasien</h3>
                                                    <button @click="viewModal = false"
                                                        class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="space-y-4 text-left">
                                                    <div>
                                                        <label
                                                            class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nama
                                                            Lengkap</label>
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                                            {{ $patient->name }}</p>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nomor
                                                            HP</label>
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                                            {{ $patient->no_hp }}</p>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-xs font-medium text-gray-500 dark:text-gray-400">Email</label>
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                                            {{ $patient->email ?? 'Tidak disertakan' }}</p>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal
                                                            Terdaftar</label>
                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                                            {{ $patient->created_at->translatedFormat('l, d F Y H:i') }}</p>
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex justify-end">
                                                    <button @click="viewModal = false" type="button"
                                                        class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- ========================================== --}}
                                    {{-- 2. MODAL EDIT DATA PASIEN --}}
                                    {{-- ========================================== --}}
                                    <template x-teleport="body">
                                        <div x-show="editModal" style="display: none;"
                                            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 p-4 backdrop-blur-sm"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                            <div @click.away="editModal = false"
                                                class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                                                <div
                                                    class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100 dark:border-gray-800">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Data
                                                        Pasien</h3>
                                                    <button @click="editModal = false"
                                                        class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <form action="#" method="POST" class="text-left space-y-4">
                                                    @csrf
                                                    @method('PUT')

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                                            Lengkap <span class="text-red-500">*</span></label>
                                                        <input type="text" name="name" value="{{ $patient->name }}"
                                                            required
                                                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500" />
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor
                                                            HP <span class="text-red-500">*</span></label>
                                                        <input type="tel" name="no_hp"
                                                            value="{{ $patient->no_hp }}" required
                                                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500" />
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                                        <input type="email" name="email"
                                                            value="{{ $patient->email }}"
                                                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500" />
                                                    </div>

                                                    <div
                                                        class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                                                        <button @click="editModal = false" type="button"
                                                            class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                                                            Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </template>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data pasien yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $patients->links() }}
            </div>

        </div>
    </div>
@endsection
