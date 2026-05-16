@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6" x-data="{ addModal: false }">

        <x-common.page-breadcrumb pageTitle="Kuesioner GAD-7" />

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90">
                        Daftar Pertanyaan Skrining
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">
                        Anda dapat menonaktifkan pertanyaan yang sudah tidak relevan tanpa menghapus histori jawaban pasien
                        sebelumnya.
                    </p>
                </div>

                {{-- Tombol Buka Modal Tambah --}}
                <button @click="addModal = true" type="button"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pertanyaan
                </button>
            </div>

            @if (session('success'))
                <div
                    class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-600 border border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-800/30">
                    {{-- Gunakan {!! !!} agar tag <strong> terbaca sebagai HTML --}}
                    {!! session('success') !!}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-600 border border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-800/30">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-tl-lg text-center w-16">Urutan</th>
                            <th scope="col" class="px-6 py-3">Teks Pertanyaan</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-center rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questions as $q)
                            <tr x-data="{ editModal: false }"
                                class="border-b bg-white dark:border-gray-800 dark:bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors">
                                <td class="px-6 py-4 font-bold text-center text-gray-900 dark:text-white">
                                    {{ $q->order_num }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-white/90">
                                    {{ $q->question }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($q->is_active)
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-500/20 dark:text-red-400">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-4">

                                        {{-- Form Toggle Switch Status --}}
                                        <form action="{{ route('admin.gad-questions.toggle', $q->id) }}" method="POST"
                                            class="inline-block m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 {{ $q->is_active ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-600' }}"
                                                title="{{ $q->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <span
                                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $q->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </form>

                                        <div class="h-5 w-px bg-gray-300 dark:bg-gray-700"></div>

                                        {{-- Tombol Buka Modal Edit (Ikon Pensil) --}}
                                        <button @click="editModal = true" type="button"
                                            class="inline-flex items-center justify-center rounded-lg bg-amber-50 p-2 text-amber-500 transition-colors hover:bg-amber-100 hover:text-amber-700 dark:bg-amber-500/10 dark:hover:bg-amber-500/20"
                                            title="Edit Pertanyaan">
                                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>

                                        {{-- ========================================== --}}
                                        {{-- MODAL EDIT PERTANYAAN (Per Baris) --}}
                                        {{-- ========================================== --}}
                                        <template x-teleport="body">
                                            <div x-show="editModal" style="display: none;"
                                                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 p-4 backdrop-blur-sm"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                                <div @click.away="editModal = false"
                                                    class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                                                    <div
                                                        class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100 dark:border-gray-800">
                                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit
                                                            Pertanyaan GAD-7</h3>
                                                        <button @click="editModal = false"
                                                            class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('admin.gad-questions.update', $q->id) }}"
                                                        method="POST" class="text-left space-y-4">
                                                        @csrf
                                                        @method('PUT')

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor
                                                                Urut <span class="text-red-500">*</span></label>
                                                            <input type="number" name="order_num"
                                                                value="{{ $q->order_num }}" required min="1"
                                                                class="w-full sm:w-1/3 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500" />
                                                            @error('order_num')
                                                                <span
                                                                    class="mt-1 block text-sm text-red-500 font-medium">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teks
                                                                Pertanyaan <span class="text-red-500">*</span></label>
                                                            <textarea name="question" rows="3" required
                                                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500">{{ $q->question }}</textarea>
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada pertanyaan GAD-7 yang diinputkan. Pastikan Anda sudah menjalankan Seeder.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL TAMBAH PERTANYAAN --}}
        {{-- ========================================== --}}
        <template x-teleport="body">
            <div x-show="addModal" style="display: none;"
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 p-4 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div @click.away="addModal = false"
                    class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                    <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Pertanyaan GAD-7 Baru</h3>
                        <button @click="addModal = false"
                            class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.gad-questions.store') }}" method="POST" class="text-left space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Urut <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="order_num" required min="1" placeholder="Contoh: 8"
                                class="w-full sm:w-1/3 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500" />
                            @error('order_num')
                                <span class="mt-1 block text-sm text-red-500 font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teks Pertanyaan
                                <span class="text-red-500">*</span></label>
                            <textarea name="question" rows="3" required placeholder="Masukkan pertanyaan skrining kecemasan..."
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white dark:focus:border-brand-500"></textarea>
                        </div>

                        <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <button @click="addModal = false" type="button"
                                class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                                Simpan Pertanyaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>
@endsection
