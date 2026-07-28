@extends('layouts.app')

@section('title', 'Periode')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pengaturan Periode Pendataan</h2>
        
        <!-- Modal Trigger -->
        <button type="button" x-data @click="$dispatch('open-modal', 'add-periode')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-sm transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Periode Baru
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr class="text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <th class="px-6 py-4">Tahun Periode</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($periodes as $periode)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-base text-gray-900 dark:text-white font-bold">{{ $periode->tahun }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($periode->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-center flex justify-center gap-2">
                            @if(!$periode->is_active)
                                <!-- Form Aktifkan -->
                                <form action="{{ route('superadmin.periode.toggle', $periode->id) }}" method="POST" class="inline-block" x-data @submit.prevent="Swal.fire({
                                    title: 'Aktifkan Periode?',
                                    text: 'Apakah Anda yakin ingin MENGAKTIFKAN periode ini? Periode lain akan otomatis dinonaktifkan.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#22c55e',
                                    cancelButtonColor: '#6b7280',
                                    confirmButtonText: 'Ya, Aktifkan!',
                                    cancelButtonText: 'Batal',
                                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                                    color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827'
                                }).then((result) => {
                                    if (result.isConfirmed) $el.submit();
                                })">
                                    @csrf
                                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/20 px-3 py-1.5 rounded text-xs font-semibold cursor-pointer">
                                        Aktifkan
                                    </button>
                                </form>

                                <!-- Form Hapus -->
                                <form action="{{ route('superadmin.periode.destroy', $periode->id) }}" method="POST" class="inline-block" x-data @submit.prevent="Swal.fire({
                                    title: 'Hapus Periode?',
                                    text: 'Apakah Anda yakin ingin MENGHAPUS periode {{ $periode->tahun }}?',
                                    icon: 'error',
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
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 px-3 py-1.5 rounded text-xs font-semibold ml-2 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Sedang Digunakan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data periode.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Periode -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'add-periode') open = true"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
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

            <!-- Modal panel -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative inline-block px-4 pt-5 pb-4 text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100 dark:border-gray-700">
                
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Tambah Periode Baru</h3>
                        <div class="mt-4">
                            <form action="{{ route('superadmin.periode.store') }}" method="POST">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Pendataan</label>
                                    <input type="number" name="tahun" required placeholder="Contoh: 2026" min="2020" max="2099" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white py-2 px-3">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Periode baru tidak akan otomatis diaktifkan. Anda harus mengaktifkannya secara manual dari tabel.</p>
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
            </div>
        </div>
    </div>
</div>
@endsection
