@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Dukungan Sistem" />

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">

            <div class="mb-6 border-b border-gray-100 pb-5 dark:border-gray-800">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pusat Bantuan & Dukungan</h3>
                <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                    Silakan lengkapi formulir di bawah ini. Laporan Anda akan langsung diteruskan ke WhatsApp Admin untuk
                    penanganan yang lebih cepat.
                </p>
            </div>

            <form action="{{ route('dukungan.send') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
                @csrf

                <div class="grid grid-cols-1 gap-x-6 gap-y-6 lg:grid-cols-2">

                    <div class="col-span-1 lg:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nama Lengkap <span
                                class="text-xs text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 px-1.5 py-0.5 rounded font-medium">Wajib</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', Auth::user()->fullname) }}" readonly
                            placeholder="Masukkan nama lengkap Anda"
                            class="bg-gray-50 cursor-not-allowed dark:bg-gray-800/50 h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90" />

                        @error('nama')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            NIM <span
                                class="text-xs text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 px-1.5 py-0.5 rounded font-medium">Wajib</span>
                        </label>
                        <input type="text" name="nim" value="{{ old('nim', Auth::user()->name) }}" readonly
                            placeholder="Contoh: 2011501020"
                            class="bg-gray-50 cursor-not-allowed dark:bg-gray-800/50 h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90" />

                        @error('nim')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Program Studi <span
                                class="text-xs text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 px-1.5 py-0.5 rounded font-medium">Wajib</span>
                        </label>
                        <input type="text" name="prodi" value="{{ old('prodi', Auth::user()->prodi) }}" readonly
                            placeholder="Contoh: Teknologi Informasi"
                            class="bg-gray-50 cursor-not-allowed dark:bg-gray-800/50 h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90" />

                        @error('prodi')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-1 lg:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Detail Permasalahan <span
                                class="text-xs text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 px-1.5 py-0.5 rounded font-medium">Wajib</span>
                        </label>
                        <textarea name="permasalahan" rows="4" required
                            placeholder="Jelaskan secara detail kendala atau permasalahan yang Anda alami pada sistem..."
                            class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">{{ old('permasalahan') }}</textarea>
                        @error('permasalahan')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-1 lg:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Screenshot / Lampiran Gambar <span
                                class="text-xs text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 px-1.5 py-0.5 rounded font-medium">Opsional</span>
                        </label>
                        <input type="file" name="gambar" accept="image/jpeg, image/png, image/jpg"
                            class="w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:rounded-lg file:border-0
                            file:bg-brand-50 file:px-4 file:py-2.5
                            file:text-sm file:font-semibold file:text-brand-700
                            hover:file:bg-brand-100
                            dark:file:bg-gray-800 dark:file:text-gray-300
                            rounded-lg border border-gray-300 shadow-theme-xs dark:border-gray-700" />
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Format yang didukung: JPG, JPEG, PNG.
                            Maksimal ukuran 2MB.</p>
                        @error('gambar')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="mt-8 flex items-center pt-2 lg:justify-end">
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-[#1DA851] focus:ring-4 focus:ring-[#25D366]/30 sm:w-auto focus:outline-hidden">

                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.01 2.011a10.035 10.035 0 0 0-8.484 15.353L2 22.5l5.245-1.503a9.982 9.982 0 0 0 4.764 1.2h.004c5.524 0 10.02-4.496 10.024-10.02A10.027 10.027 0 0 0 12.01 2.011zm0 18.256a8.27 8.27 0 0 1-4.228-1.157l-.303-.18-3.143.901.916-3.064-.197-.314A8.25 8.25 0 0 1 3.738 11.99c0-4.562 3.712-8.274 8.274-8.274 2.212 0 4.29.862 5.854 2.427a8.273 8.273 0 0 1 2.425 5.857c-.004 4.563-3.715 8.267-8.28 8.267zm4.536-6.19c-.248-.124-1.472-.727-1.701-.81-.228-.083-.395-.124-.561.124-.166.248-.644.81-.789.976-.145.166-.29.186-.538.062a6.76 6.76 0 0 1-2.002-1.238 7.456 7.456 0 0 1-1.39-1.737c-.145-.248-.016-.381.108-.505.112-.111.248-.29.372-.435.124-.145.166-.248.248-.414.083-.165.042-.31-.02-.434-.063-.124-.561-1.355-.769-1.854-.203-.487-.409-.42-.561-.428-.145-.008-.312-.01-.478-.01a.916.916 0 0 0-.663.31c-.228.248-.871.852-.871 2.078s.892 2.408 1.016 2.573c.124.166 1.753 2.676 4.246 3.753.593.256 1.056.41 1.418.524.596.189 1.139.162 1.565.098.475-.071 1.472-.602 1.68-1.184.207-.582.207-1.082.145-1.184-.062-.103-.228-.165-.476-.29z" />
                        </svg>
                        Kirim Laporan via WhatsApp
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
