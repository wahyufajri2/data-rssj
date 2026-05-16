@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-4xl md:p-6" x-data="{
        isModalOpen: false,
        selectedData: null,
        openModal(data) {
            this.selectedData = data;
            this.isModalOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.isModalOpen = false;
            setTimeout(() => this.selectedData = null, 300);
            document.body.style.overflow = 'auto';
        }
    }">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">Riwayat Perjalanan Anda</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Pantau perkembangan suasana hati dan tingkat kecemasan
                Anda dari waktu ke waktu.</p>
        </div>

        <div class="space-y-4">
            @forelse ($screenings as $screening)
                <div
                    class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-5 shadow-theme-xs transition-all hover:shadow-md dark:border-gray-800 dark:bg-gray-900/50">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        {{-- Tanggal & Waktu --}}
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $screening->completed_at ? \Carbon\Carbon::parse($screening->completed_at)->timezone('Asia/Jakarta')->translatedFormat('l, d F Y - H:i') : 'Sesi Belum Selesai' }}
                            </div>
                        </div>

                        {{-- Skor Badges --}}
                        <div class="flex flex-wrap items-center gap-3">
                            {{-- Badge VAS --}}
                            <div
                                class="flex items-center gap-2 rounded-xl bg-gray-50 px-3 py-1.5 border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Mood (VAS):</span>
                                <span
                                    class="text-sm font-bold text-brand-600 dark:text-brand-400">{{ $screening->vas_score }}/10</span>
                            </div>

                            {{-- Badge GAD-7 --}}
                            <div
                                class="flex items-center gap-2 rounded-xl bg-gray-50 px-3 py-1.5 border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kecemasan:</span>
                                @if (is_null($screening->gad_score))
                                    <span class="text-sm font-bold text-gray-400">Tidak Skrining</span>
                                @else
                                    <span
                                        class="text-sm font-bold text-orange-500">{{ ucfirst($screening->gad_category) }}</span>
                                @endif
                            </div>

                            <button
                                @click="openModal({
                            tanggal: '{{ $screening->completed_at ? \Carbon\Carbon::parse($screening->completed_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }}',
                            vas_score: '{{ $screening->vas_score }}',
                            vas_category: '{{ ucfirst($screening->vas_category) }}',
                            gad_score: '{{ $screening->gad_score ?? '-' }}',
                            gad_category: '{{ ucfirst($screening->gad_category ?? 'Tidak Skrining') }}',
                            answers: {{ $screening->gadAnswers->count() > 0? json_encode($screening->gadAnswers->map(function ($ans) {return ['pertanyaan' => $ans->question->question ?? 'Pertanyaan dihapus', 'skor' => $ans->score];})): '[]' }}
                        })"
                                class="ml-auto sm:ml-0 rounded-full bg-brand-50 p-2 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-gray-200 bg-gray-50 py-16 text-center dark:border-gray-800 dark:bg-gray-900/30">
                    <div class="mb-4 rounded-full bg-white p-4 shadow-sm dark:bg-gray-800">
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada Riwayat</h3>
                    <p class="mt-1 max-w-sm text-sm text-gray-500 dark:text-gray-400">Anda belum menyelesaikan sesi skrining
                        apa pun. Mari mulai skrining pertama Anda hari ini.</p>
                    <a href="{{ route('pasien.skrining-awal') }}"
                        class="mt-6 rounded-xl bg-brand-500 px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-brand-600 transition-colors">
                        Mulai Skrining
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $screenings->links() }}
        </div>

        {{-- Modal Detail (Menggunakan struktur yang sama dengan milik Admin, disederhanakan) --}}
        <div x-show="isModalOpen" style="display: none;" class="relative z-50">
            <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="isModalOpen" @click.away="closeModal()" x-transition
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">

                        <div
                            class="border-b border-gray-100 px-6 py-4 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/30">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Rincian Skrining Anda</h3>
                            <button @click="closeModal()"
                                class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="px-6 py-5">
                            <template x-if="selectedData">
                                <div class="space-y-6">
                                    <p class="text-sm font-medium text-gray-500 text-center"
                                        x-text="'Sesi: ' + selectedData.tanggal"></p>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="rounded-xl border border-gray-200 p-4 text-center dark:border-gray-700">
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                                Skor Mood Awal</p>
                                            <p class="text-2xl font-black text-brand-600 dark:text-brand-400"
                                                x-text="selectedData.vas_score + '/10'"></p>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1"
                                                x-text="selectedData.vas_category"></p>
                                        </div>
                                        <div class="rounded-xl border border-gray-200 p-4 text-center dark:border-gray-700">
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                                Skor GAD-7</p>
                                            <p class="text-2xl font-black text-orange-500" x-text="selectedData.gad_score">
                                            </p>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1"
                                                x-text="selectedData.gad_category"></p>
                                        </div>
                                    </div>

                                    <div x-show="selectedData.answers && selectedData.answers.length > 0">
                                        <h4 class="font-bold text-gray-800 dark:text-white mb-3 text-sm">Jawaban Kuesioner:
                                        </h4>
                                        <div class="space-y-2">
                                            <template x-for="(ans, index) in selectedData.answers" :key="index">
                                                <div
                                                    class="flex justify-between items-start gap-4 p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                                                    <p class="text-sm text-gray-600 dark:text-gray-300"
                                                        x-text="ans.pertanyaan"></p>
                                                    <span
                                                        class="inline-flex shrink-0 items-center justify-center rounded-md bg-white px-2 py-1 text-xs font-bold text-gray-700 shadow-xs dark:bg-gray-700 dark:text-gray-200"
                                                        x-text="ans.skor + ' Poin'"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
