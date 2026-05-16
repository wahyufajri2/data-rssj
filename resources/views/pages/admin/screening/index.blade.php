@extends('layouts.app')

@section('content')
    {{-- Wrapper utama dengan Alpine x-data untuk mengontrol modal detail --}}
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6" x-data="{
        isModalOpen: false,
        selectedData: null,
        openModal(data) {
            this.selectedData = data;
            this.isModalOpen = true;
            document.body.style.overflow = 'hidden'; // Mencegah scrolling latar belakang
        },
        closeModal() {
            this.isModalOpen = false;
            setTimeout(() => this.selectedData = null, 300);
            document.body.style.overflow = 'auto';
        }
    }">

        <x-common.page-breadcrumb pageTitle="Histori Skrining" />

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white/90">
                    Riwayat Skrining Pasien
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-800/50 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-tl-lg">Nama Pasien</th>
                            <th scope="col" class="px-6 py-3 text-center">VAS (Mood Awal)</th>
                            <th scope="col" class="px-6 py-3 text-center">Skor GAD-7</th>
                            <th scope="col" class="px-6 py-3 text-center">Kategori Kecemasan</th>
                            <th scope="col" class="px-6 py-3">Waktu Selesai</th>
                            <th scope="col" class="px-6 py-3 text-center rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($screenings as $screening)
                            <tr
                                class="border-b bg-white dark:border-gray-800 dark:bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors">

                                {{-- 1. Nama Pasien --}}
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $screening->user->name ?? 'Pengguna Dihapus' }}
                                    <div class="font-normal text-xs text-gray-500">{{ $screening->user->no_hp ?? '-' }}
                                    </div>
                                </td>

                                {{-- 2. Skor & Kategori VAS (Perasaan Awal) --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="font-bold text-gray-800 dark:text-white/90 mb-1">
                                        {{ $screening->vas_score }} / 10
                                    </div>
                                    @php
                                        $vasCat = strtolower($screening->vas_category);
                                        $vasBadge = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';

                                        if ($vasCat === 'ringan') {
                                            $vasBadge =
                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                        } elseif ($vasCat === 'sedang') {
                                            $vasBadge =
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                        } elseif ($vasCat === 'berat') {
                                            $vasBadge = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                        }
                                    @endphp
                                    <span
                                        class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $vasBadge }}">
                                        {{ ucfirst($screening->vas_category) }}
                                    </span>
                                </td>

                                {{-- 3. Skor GAD-7 --}}
                                <td class="px-6 py-4 text-center font-bold text-gray-800 dark:text-white/90">
                                    @if (is_null($screening->gad_score))
                                        <span class="text-gray-400 font-normal text-xs italic">Tidak Skrining</span>
                                    @else
                                        {{ $screening->gad_score }}
                                    @endif
                                </td>

                                {{-- 4. Kategori GAD-7 --}}
                                <td class="px-6 py-4 text-center">
                                    @if (is_null($screening->gad_category))
                                        <span class="text-gray-400 font-normal text-xs italic">Tidak Skrining GAD</span>
                                    @else
                                        @php
                                            $kategori = strtolower($screening->gad_category);
                                            $badgeClass =
                                                'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';

                                            if ($kategori === 'minimal' || $kategori === 'normal') {
                                                $badgeClass =
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400';
                                            } elseif ($kategori === 'ringan') {
                                                $badgeClass =
                                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                            } elseif ($kategori === 'sedang') {
                                                $badgeClass =
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                            } elseif ($kategori === 'berat') {
                                                $badgeClass =
                                                    'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                            }
                                        @endphp
                                        <span
                                            class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                            {{ ucfirst($screening->gad_category) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- 5. Waktu Selesai --}}
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    {{ $screening->completed_at ? \Carbon\Carbon::parse($screening->completed_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') : 'Belum Selesai' }}
                                </td>

                                {{-- 6. Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <button type="button"
                                        @click="openModal({
                                            nama: '{{ addslashes($screening->user->name ?? 'Pengguna Dihapus') }}',
                                            no_hp: '{{ addslashes($screening->user->no_hp ?? '-') }}',
                                            tanggal: '{{ $screening->completed_at ? \Carbon\Carbon::parse($screening->completed_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }}',
                                            vas_score: '{{ $screening->vas_score }}',
                                            vas_category: '{{ ucfirst($screening->vas_category) }}',
                                            gad_score: '{{ $screening->gad_score ?? '-' }}',
                                            gad_category: '{{ ucfirst($screening->gad_category ?? 'Tidak Skrining') }}',
                                            // Mengambil relasi jawaban (jika ada) dan mengubahnya ke JSON
                                            answers: {{ $screening->gadAnswers->count() > 0? json_encode($screening->gadAnswers->map(function ($ans) {return ['pertanyaan' => $ans->question->question ?? 'Pertanyaan dihapus', 'skor' => $ans->score];})): '[]' }}
                                        })"
                                        class="inline-flex items-center justify-center rounded-lg bg-brand-50 p-2 text-brand-500 transition-colors hover:bg-brand-100 hover:text-brand-700 dark:bg-brand-500/10 dark:hover:bg-brand-500/20"
                                        title="Lihat Detail Sesi">
                                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 bg-gray-50/50 dark:bg-gray-800/20">
                                    Belum ada riwayat skrining yang diselesaikan oleh pasien.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $screenings->links() }}
            </div>
        </div>

        {{-- ================= MODAL DETAIL SKRINING ================= --}}
        <div x-show="isModalOpen" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">

            {{-- Background Backdrop --}}
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                    {{-- Modal Panel --}}
                    <div x-show="isModalOpen" @click.away="closeModal()" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">

                        {{-- Header Modal --}}
                        <div
                            class="border-b border-gray-100 px-6 py-4 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/30">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white" id="modal-title">
                                Detail Riwayat Skrining
                            </h3>
                            <button @click="closeModal()"
                                class="text-gray-400 hover:text-gray-500 focus:outline-hidden dark:hover:text-gray-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Body Modal --}}
                        <div class="px-6 py-5">
                            <template x-if="selectedData">
                                <div class="space-y-6">

                                    {{-- Info Pasien & Waktu --}}
                                    <div class="grid grid-cols-2 gap-4 rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Nama Pasien</p>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200"
                                                x-text="selectedData.nama"></p>
                                            <p class="text-xs text-gray-500" x-text="selectedData.no_hp"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Waktu Penyelesaian</p>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200"
                                                x-text="selectedData.tanggal"></p>
                                        </div>
                                    </div>

                                    {{-- Skor Ringkasan --}}
                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            class="rounded-xl border border-gray-200 p-4 text-center dark:border-gray-700">
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                                Skor VAS Awal</p>
                                            <p class="text-2xl font-black text-brand-600 dark:text-brand-400"
                                                x-text="selectedData.vas_score + '/10'"></p>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1"
                                                x-text="selectedData.vas_category"></p>
                                        </div>
                                        <div
                                            class="rounded-xl border border-gray-200 p-4 text-center dark:border-gray-700">
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                                Total GAD-7</p>
                                            <p class="text-2xl font-black text-orange-500"
                                                x-text="selectedData.gad_score"></p>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1"
                                                x-text="selectedData.gad_category"></p>
                                        </div>
                                    </div>

                                    {{-- Detail Jawaban GAD-7 (Muncul Jika Ada) --}}
                                    <div x-show="selectedData.answers && selectedData.answers.length > 0" class="mt-6">
                                        <h4 class="font-bold text-gray-800 dark:text-white mb-3 text-sm uppercase">Detail
                                            Jawaban GAD-7</h4>
                                        <div
                                            class="rounded-xl border border-gray-200 overflow-hidden dark:border-gray-700">
                                            <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                                                <thead class="bg-gray-50 text-xs dark:bg-gray-800">
                                                    <tr>
                                                        <th class="px-4 py-2 font-medium">Pertanyaan</th>
                                                        <th class="px-4 py-2 font-medium text-center w-20">Poin</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                                    <template x-for="(ans, index) in selectedData.answers"
                                                        :key="index">
                                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                                            <td class="px-4 py-2.5 text-xs leading-relaxed"
                                                                x-text="ans.pertanyaan"></td>
                                                            <td class="px-4 py-2.5 text-center font-bold text-gray-800 dark:text-gray-200"
                                                                x-text="ans.skor"></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>

                        {{-- Footer Modal --}}
                        <div
                            class="bg-gray-50 px-6 py-4 dark:bg-gray-800/50 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-gray-800">
                            <button type="button" @click="closeModal()"
                                class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-theme-xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ================= END MODAL ================= --}}

    </div>
@endsection
