@extends('layouts.app')

@section('title', 'Data Daerah')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<style>
    /* Custom styling for Simple DataTables */
    .datatable-wrapper .datatable-container {
        border-bottom: 1px solid #e5e7eb;
        overflow-x: auto;
    }
    .datatable-table > tbody > tr > td, .datatable-table > tbody > tr > th, 
    .datatable-table > tfoot > tr > td, .datatable-table > tfoot > tr > th, 
    .datatable-table > thead > tr > td, .datatable-table > thead > tr > th {
        padding: 1rem 1.5rem;
    }
    .datatable-table > thead > tr > th {
        border-bottom: 1px solid #e5e7eb;
    }
    
    .datatable-input, .datatable-selector {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.5rem;
        background-color: white;
    }
    .datatable-info, .datatable-pagination, .datatable-dropdown, .datatable-search {
        margin: 1rem 0;
    }
    .datatable-pagination a {
        color: #3b82f6;
    }
    .datatable-pagination a:hover {
        background-color: #eff6ff;
    }
    .datatable-pagination .active a, .datatable-pagination .active a:focus, .datatable-pagination .active a:hover {
        background-color: #3b82f6;
        color: white;
    }

    /* DARK MODE STYLES - using !important where necessary to override library defaults */
    .dark .datatable-wrapper .datatable-container {
        border-bottom: 1px solid #374151 !important;
    }
    .dark .datatable-table > thead > tr > th {
        color: #e5e7eb !important;
        border-bottom: 1px solid #374151 !important;
    }
    .dark .datatable-table > tbody > tr > td {
        color: #d1d5db !important;
        border-bottom: 1px solid #374151 !important;
    }
    .dark .datatable-table > tbody > tr:hover {
        background-color: rgba(55, 65, 81, 0.5) !important;
    }
    .dark .datatable-sorter::before, .dark .datatable-sorter::after {
        opacity: 0.4;
    }
    .dark .datatable-input, .dark .datatable-selector {
        background-color: #1f2937 !important;
        border-color: #4b5563 !important;
        color: #f3f4f6 !important;
    }
    .dark .datatable-info, 
    .dark .datatable-dropdown label, 
    .dark .datatable-search label, 
    .dark .datatable-top, 
    .dark .datatable-bottom {
        color: #f3f4f6 !important;
    }
    .dark .datatable-pagination a {
        color: #60a5fa !important;
    }
    .dark .datatable-pagination a:hover {
        background-color: #1e3a8a !important;
    }
    .dark .datatable-pagination .active a, .datatable-pagination .active a:focus, .datatable-pagination .active a:hover {
        background-color: #3b82f6 !important;
        color: white !important;
    }
    .dark .datatable-table {
        border-color: #374151 !important;
    }
</style>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Data Daerah</h2>
        
        <button type="button" x-data @click="$dispatch('open-modal', 'add-daerah')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-sm transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Daerah
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden p-4">
        <table id="daerahTable" class="w-full whitespace-nowrap table-auto text-gray-900 dark:text-gray-100">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr class="text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                    <th>No</th>
                    <th>Nama Kabupaten/Kota</th>
                    <th>No SK</th>
                    <th>Nama Wilayah</th>
                    <th class="text-center" data-sortable="false">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($daerahs as $index => $daerah)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="text-gray-700 dark:text-gray-200">{{ $index + 1 }}</td>
                    <td class="font-medium text-gray-900 dark:text-white">{{ $daerah->nama_kabupaten_kota }}</td>
                    <td class="text-gray-700 dark:text-gray-200">{{ $daerah->no_sk }}</td>
                    <td class="text-gray-700 dark:text-gray-200">{{ $daerah->nama_wilayah }}</td>
                    <td class="text-center">
                        <div class="flex justify-center gap-2">
                            <button type="button" 
                                x-data="{ 
                                    daerahId: '{{ $daerah->id }}', 
                                    nama: '{{ $daerah->nama_kabupaten_kota }}', 
                                    sk: '{{ $daerah->no_sk }}', 
                                    wilayah: '{{ $daerah->nama_wilayah }}' 
                                }" 
                                @click="$dispatch('open-edit-modal', { id: daerahId, nama: nama, sk: sk, wilayah: wilayah })"
                                class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 bg-amber-50 dark:bg-amber-900/20 px-3 py-1.5 rounded text-xs font-semibold cursor-pointer">
                                Edit
                            </button>

                            <form action="{{ route('superadmin.daerah.destroy', $daerah->id) }}" method="POST" class="inline-block" x-data @submit.prevent="Swal.fire({
                                title: 'Hapus Daerah?',
                                text: 'Apakah Anda yakin ingin menghapus daerah {{ $daerah->nama_kabupaten_kota }}?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Ya, Hapus!',
                                cancelButtonText: 'Batal',
                                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827'
                            }).then((result) => {
                                if (result.isConfirmed) $el.submit();
                            })">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 px-3 py-1.5 rounded text-xs font-semibold cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Daerah -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'add-daerah') open = true"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm" 
                 @click="open = false">
            </div>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative inline-block px-4 pt-5 pb-4 text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100 dark:border-gray-700">
                
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Tambah Data Daerah</h3>
                <form action="{{ route('superadmin.daerah.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kabupaten/Kota</label>
                            <input type="text" name="nama_kabupaten_kota" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No SK</label>
                            <input type="text" name="no_sk" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Wilayah</label>
                            <input type="text" name="nama_wilayah" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Daerah -->
    <div x-data="{ open: false, id: '', nama: '', sk: '', wilayah: '' }" 
         x-show="open" 
         @open-edit-modal.window="open = true; id = $event.detail.id; nama = $event.detail.nama; sk = $event.detail.sk; wilayah = $event.detail.wilayah"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm" 
                 @click="open = false">
            </div>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative inline-block px-4 pt-5 pb-4 text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100 dark:border-gray-700">
                
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Edit Data Daerah</h3>
                <form :action="`/superadmin/daerah/${id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kabupaten/Kota</label>
                            <input type="text" name="nama_kabupaten_kota" x-model="nama" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No SK</label>
                            <input type="text" name="no_sk" x-model="sk" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Wilayah</label>
                            <input type="text" name="nama_wilayah" x-model="wilayah" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("#daerahTable");
        if (table) {
            new simpleDatatables.DataTable(table, {
                labels: {
                    placeholder: "Cari...",
                    perPage: "entri per halaman",
                    noRows: "Tidak ada data yang ditemukan",
                    info: "Menampilkan {start} hingga {end} dari {rows} entri",
                    searchTitle: "Cari"
                }
            });
        }
    });
</script>
@endpush
