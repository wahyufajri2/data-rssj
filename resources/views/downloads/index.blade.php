@extends('layouts.app')

@section('title', 'Unduh Data')
@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Unduh Data</h2>
        <p class="text-gray-500 text-sm mt-1">Unduh laporan rekapitulasi data dalam format Excel.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                
                <!-- Ilustrasi -->
                <div class="hidden md:flex justify-center items-center p-6">
                    <div class="w-full max-w-sm rounded-2xl bg-green-50 dark:bg-green-900/20 p-8 flex flex-col items-center justify-center text-center">
                        <svg class="w-32 h-32 text-emerald-500 mb-4 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-emerald-700 dark:text-emerald-400">Ekspor Laporan</h3>
                        <p class="text-sm text-emerald-600/80 dark:text-emerald-400/80 mt-2">Dapatkan rekapitulasi data dengan format Excel yang rapi dan siap cetak.</p>
                    </div>
                </div>

                <!-- Form -->
                <div>
                    <form action="{{ route('downloads.export', ['role' => Auth::user()->role === 'admin_ranting' ? 'admin-ranting' : Auth::user()->role]) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Pilihan Data -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Jenis Data</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500 has-[:checked]:border-emerald-500 transition-all">
                                    <input type="radio" name="jenis_data" value="pendataan" class="sr-only" checked>
                                    <span class="flex flex-col text-center w-full">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">RSSJ</span>
                                        <span class="block mt-1 text-xs text-gray-500 dark:text-gray-400">Data Pendataan</span>
                                    </span>
                                </label>
                                
                                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500 has-[:checked]:border-emerald-500 transition-all">
                                    <input type="radio" name="jenis_data" value="kuesioner" class="sr-only">
                                    <span class="flex flex-col text-center w-full">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Kuesioner</span>
                                        <span class="block mt-1 text-xs text-gray-500 dark:text-gray-400">Mandiri SRQ</span>
                                    </span>
                                </label>

                                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 has-[:checked]:ring-2 has-[:checked]:ring-purple-500 has-[:checked]:border-purple-500 transition-all">
                                    <input type="radio" name="jenis_data" value="semua" class="sr-only">
                                    <span class="flex flex-col text-center w-full">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Semua Data</span>
                                        <span class="block mt-1 text-xs text-gray-500 dark:text-gray-400">Gabungan</span>
                                    </span>
                                </label>
                            </div>
                            @error('jenis_data')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Filter Periode (Berlaku untuk semua role) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filter Berdasarkan Periode</label>
                            <select name="periode_id" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer shadow-sm">
                                <option value="">-- Semua Periode --</option>
                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}">Tahun {{ $periode->tahun }} {!! $periode->is_active ? '&#10003; (Aktif)' : '' !!}</option>
                                @endforeach
                            </select>
                            @error('periode_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Pilih tahun periode untuk membatasi data, atau biarkan kosong untuk mengunduh semua periode.</p>
                        </div>

                        <!-- Filter Ranting (Khusus Superadmin) -->
                        @if(Auth::user()->role === 'superadmin')
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filter Berdasarkan Ranting</label>
                            <div x-data="searchableSelect()" class="relative">
                                <!-- Hidden Select for Native Validation & Submission -->
                                <select name="ranting_id" x-model="selectedId" class="absolute inset-0 opacity-0 w-full h-full -z-10 pointer-events-none">
                                    <option value="">-- Semua Ranting --</option>
                                    @foreach($rantings as $ranting)
                                        <option value="{{ $ranting->id }}">{{ $ranting->nama_ranting }}</option>
                                    @endforeach
                                </select>
                                
                                <!-- Custom Select Button -->
                                <div @click="open = !open" @click.away="open = false" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer flex justify-between items-center shadow-sm">
                                    <span x-text="selectedName || '-- Semua Ranting --'" :class="{'text-gray-500 dark:text-gray-400': !selectedName || selectedName === '-- Semua Ranting --'}"></span>
                                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>

                                <!-- Dropdown Menu -->
                                <div x-show="open" x-cloak class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl overflow-hidden" x-transition.opacity.duration.200ms>
                                    <div class="p-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                        <input type="text" x-model="search" x-ref="searchInput" placeholder="Ketik untuk mencari ranting..." class="w-full px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm">
                                    </div>
                                    <ul class="max-h-56 overflow-y-auto custom-scrollbar py-1">
                                        <!-- Option: Semua Ranting -->
                                        <li @click="selectOption({id: '', name: '-- Semua Ranting --'})" class="px-4 py-2.5 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition-colors flex items-center justify-between" :class="{'bg-gray-50 dark:bg-gray-700 font-medium text-emerald-600 dark:text-emerald-400': selectedId === ''}">
                                            <span>-- Semua Ranting --</span>
                                            <svg x-show="selectedId === ''" class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </li>
                                        <!-- Dinamis Options -->
                                        <template x-for="ranting in filteredRantings" :key="ranting.id">
                                            <li @click="selectOption(ranting)" class="px-4 py-2.5 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition-colors flex items-center justify-between" :class="{'bg-gray-50 dark:bg-gray-700 font-medium text-emerald-600 dark:text-emerald-400': selectedId == ranting.id}">
                                                <span x-text="ranting.name"></span>
                                                <svg x-show="selectedId == ranting.id" class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </li>
                                        </template>
                                        <li x-show="filteredRantings.length === 0" class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Tidak ada ranting ditemukan
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @error('ranting_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Biarkan "-- Semua Ranting --" jika ingin mengunduh keseluruhan data dari berbagai wilayah.</p>
                        </div>
                        @else
                            <input type="hidden" name="ranting_id" value="{{ Auth::user()->ranting_id }}">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 flex gap-3 border border-blue-100 dark:border-blue-800">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <p class="text-sm text-blue-800 dark:text-blue-300">
                                        Anda akan mengunduh data khusus untuk wilayah <span class="font-bold">{{ Auth::user()->ranting->nama_ranting ?? 'Ranting Anda' }}</span>.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                            <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-medium text-sm transition-all shadow-md hover:shadow-lg focus:ring-4 focus:ring-emerald-500/30 active:scale-[0.98]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Mulai Unduh Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('searchableSelect', () => ({
        open: false,
        search: '',
        selectedId: '{{ old("ranting_id") }}' || '',
        selectedName: '',
        rantings: [
            @if(isset($rantings))
                @foreach($rantings as $ranting)
                    { id: '{{ $ranting->id }}', name: '{!! addslashes($ranting->nama_ranting) !!}' },
                @endforeach
            @endif
        ],
        init() {
            if (this.selectedId) {
                const found = this.rantings.find(r => r.id == this.selectedId);
                if (found) {
                    this.selectedName = found.name;
                }
            } else {
                this.selectedName = '-- Semua Ranting --';
            }
            this.$watch('open', value => {
                if (value) {
                    this.$nextTick(() => {
                        this.$refs.searchInput.focus();
                    });
                }
            });
        },
        get filteredRantings() {
            if (this.search === '') {
                return this.rantings;
            }
            return this.rantings.filter(r => r.name.toLowerCase().includes(this.search.toLowerCase()));
        },
        selectOption(ranting) {
            this.selectedId = ranting.id;
            this.selectedName = ranting.name;
            this.open = false;
            this.search = '';
        }
    }));
});
</script>
@endsection
