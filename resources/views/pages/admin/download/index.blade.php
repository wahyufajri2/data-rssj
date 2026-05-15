@extends('layouts.app')

@section('content')
    {{-- 
        SIMULASI DATA DARI CONTROLLER:
        Pastikan Controller Anda mengirimkan variable:
        1. $prodi -> List semua prodi
        2. $userProdiId -> ID Prodi user yang sedang login (NULL jika Admin/Superuser)
    --}}
    @php
        // Contoh logika pengambilan session ID Prodi (Sesuaikan dengan logic Auth Anda)
        // Jika Admin, nilainya null. Jika Kaprodi, nilainya ID prodi mereka.
        $userProdiId = session('prodi_id') ?? (auth()->user()->prodi_id ?? null);
    @endphp

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Unduh Pengajuan" />

        <div class="space-y-5 sm:space-y-6">
            {{-- Main Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] relative overflow-hidden"
                {{-- Init Alpine dengan data session Prodi --}} x-data="downloadPage('{{ $userProdiId }}')">

                {{-- Loading Overlay --}}
                <div x-show="isDownloading" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm">
                    <div
                        class="flex items-center gap-3 px-6 py-3 bg-white rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                        <svg class="w-6 h-6 text-brand-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="font-medium text-gray-700 dark:text-gray-200">Sedang memproses unduhan...</span>
                    </div>
                </div>

                {{-- Filter Header --}}
                <div class="px-6 py-8">
                    {{-- Grid diubah jadi 5 kolom agar muat (Jenis, Status, Periode, Prodi, Tombol) --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 items-end">

                        {{-- Filter: Jenis Pengajuan --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis
                                Pengajuan</label>
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
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status
                                Pengajuan</label>
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

                        {{-- Filter: Periode --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Periode
                                Akademik</label>
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

                        {{-- Filter: Prodi --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Program
                                Studi</label>
                            <div class="relative z-20 bg-transparent">
                                <select x-model="params.prodi" :disabled="isRestricted"
                                    :class="isRestricted ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed text-gray-500' :
                                        'bg-transparent text-gray-800 dark:text-white/90'"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-none px-4 py-2.5 pr-11 text-sm placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:placeholder:text-white/30">

                                    {{-- PERBAIKAN DI SINI: Menambahkan class pada option --}}
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                        Semua Prodi
                                    </option>

                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->id_unitkerja }}"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            {{ $item->prodi }}
                                        </option>
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

                        {{-- Tombol Unduh --}}
                        <div>
                            <button @click="downloadData()" :disabled="isDownloading"
                                class="flex w-full h-11 items-center justify-center gap-2 rounded-lg text-sm font-medium transition-all duration-200 
                                           bg-green-200 text-green-700 hover:text-green-50 hover:bg-green-800 dark:bg-green-800 dark:text-white dark:hover:bg-green-700 active:scale-95 shadow-md hover:shadow-lg
                                           disabled:opacity-50 disabled:cursor-not-allowed disabled:active:scale-100">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span x-text="isDownloading ? 'Memproses...' : 'Unduh Data'"></span>
                            </button>
                        </div>

                    </div>

                    {{-- Helper Text --}}
                    <p class="mt-4 text-xs text-gray-400 dark:text-gray-500">
                        *Data akan diunduh dalam format .xlsx sesuai dengan filter yang dipilih di atas.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Alpine JS --}}
    <script>
        // Menerima parameter userProdiId dari Blade
        function downloadPage(userProdiId = '') {
            return {
                isDownloading: false,
                // Cek apakah user punya ID Prodi tertentu (bukan string kosong)
                isRestricted: userProdiId !== '' && userProdiId !== null,

                params: {
                    jenis: '',
                    status: '',
                    periode: '',
                    // Set prodi default ke ID user jika ada, jika tidak kosongkan
                    prodi: userProdiId || ''
                },

                downloadData() {
                    this.isDownloading = true;

                    // Buat Query String dari params
                    const queryString = new URLSearchParams(this.params).toString();

                    // Ganti URL ini dengan route export controller Anda
                    const downloadUrl = `{{ route('admin.unduh.process') }}?${queryString}`;

                    // Simulasi delay & trigger download
                    setTimeout(() => {
                        window.location.href = downloadUrl;

                        setTimeout(() => {
                            this.isDownloading = false;
                        }, 2000);
                    }, 1000);
                }
            }
        }
    </script>
@endsection
