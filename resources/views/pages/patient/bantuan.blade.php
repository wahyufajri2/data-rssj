@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-4xl md:p-6">

        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">Pusat Bantuan EMBRACE</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Kami di sini untuk membantu Anda. Temukan
                jawaban atas pertanyaan Anda, pelajari cara kerja aplikasi, atau hubungi profesional jika Anda membutuhkan
                bantuan segera.</p>
        </div>

        {{-- Fitur 1: Kontak Darurat (Krusial untuk Aplikasi Mental Health) --}}
        <div
            class="mb-12 rounded-3xl bg-gradient-to-br from-red-50 to-orange-50 p-6 sm:p-8 border border-red-100 dark:from-red-900/20 dark:to-orange-900/20 dark:border-red-900/30 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-red-500/10 blur-3xl"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h2 class="text-xl font-bold text-red-700 dark:text-red-400 mb-2 flex items-center gap-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Butuh Bantuan Segera?
                    </h2>
                    <p class="text-sm text-red-900/80 dark:text-red-200/80 max-w-xl">
                        Jika Anda merasa dalam kondisi krisis, ingin menyakiti diri sendiri, atau membutuhkan pertolongan
                        psikologis mendesak, mohon jangan ragu untuk menghubungi layanan darurat.
                    </p>
                </div>
                <div class="shrink-0 flex flex-col gap-3">
                    <a href="tel:+6285747039355"
                        class="flex items-center justify-center gap-2 rounded-xl bg-red-600 px-6 py-3 text-sm font-normal text-white shadow-md hover:bg-red-700 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Hubungi <strong>(Nuzul)</strong>
                    </a>
                </div>
            </div>
        </div>

        {{-- Fitur 2: FAQ (Frequently Asked Questions) menggunakan Alpine.js --}}
        <div class="mb-12">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="h-5 w-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pertanyaan yang Sering Diajukan (FAQ)
            </h3>

            <div class="space-y-4" x-data="{ activeAccordion: null }">
                {{-- Item FAQ 1 --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden transition-all duration-200">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                        class="flex w-full items-center justify-between px-6 py-4 text-left focus:outline-hidden">
                        <span class="font-semibold text-gray-800 dark:text-white">Apa itu Skrining GAD-7?</span>
                        <svg class="h-5 w-5 transform text-brand-500 transition-transform duration-200"
                            :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse>
                        <div
                            class="px-6 pb-5 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-50 dark:border-gray-800 pt-4 mt-2">
                            GAD-7 (Generalized Anxiety Disorder 7) adalah alat ukur yang teruji secara klinis dan digunakan
                            di seluruh dunia untuk mengidentifikasi kemungkinan gangguan kecemasan umum. Skrining ini hanya
                            memakan waktu 1-2 menit dan hasilnya akan merekomendasikan intervensi relaksasi yang paling
                            cocok untuk kondisi Anda saat ini.
                        </div>
                    </div>
                </div>

                {{-- Item FAQ 2 --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden transition-all duration-200">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                        class="flex w-full items-center justify-between px-6 py-4 text-left focus:outline-hidden">
                        <span class="font-semibold text-gray-800 dark:text-white">Apakah kerahasiaan data saya
                            terjamin?</span>
                        <svg class="h-5 w-5 transform text-brand-500 transition-transform duration-200"
                            :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse>
                        <div
                            class="px-6 pb-5 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-50 dark:border-gray-800 pt-4 mt-2">
                            Tentu saja. Privasi adalah prioritas utama kami. Data hasil skrining dan informasi pribadi Anda
                            disimpan dengan aman menggunakan standar keamanan tinggi dan hanya dapat diakses oleh Anda dan
                            tenaga medis/admin yang memiliki wewenang khusus dalam proses perawatan Anda.
                        </div>
                    </div>
                </div>

                {{-- Item FAQ 3 --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden transition-all duration-200">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                        class="flex w-full items-center justify-between px-6 py-4 text-left focus:outline-hidden">
                        <span class="font-semibold text-gray-800 dark:text-white">Seberapa sering saya harus melakukan
                            skrining?</span>
                        <svg class="h-5 w-5 transform text-brand-500 transition-transform duration-200"
                            :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse>
                        <div
                            class="px-6 pb-5 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-50 dark:border-gray-800 pt-4 mt-2">
                            Kami menyarankan Anda untuk melakukan Skrining Perasaan (Mood/VAS) setiap hari, atau kapan pun
                            Anda merasa emosi Anda sedang tidak stabil. Namun, untuk skrining GAD-7, biasanya disarankan
                            untuk mengisinya 1-2 minggu sekali untuk melihat tren kecemasan dalam rentang waktu yang lebih
                            luas.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fitur 3: Dukungan Lanjutan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Kartu WhatsApp Admin --}}
            <a href="https://wa.me/6285747039355?text=Halo%20Admin%20EMBRACE,%20saya%20mengalami%20kendala%20teknis%20pada%20aplikasi."
                target="_blank" rel="noopener noreferrer"
                class="group flex items-start gap-4 rounded-2xl border border-brand-100 bg-brand-50/50 p-5 hover:bg-brand-100/50 transition-colors dark:border-brand-900/30 dark:bg-brand-900/10 dark:hover:bg-brand-900/20">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900/50 dark:text-brand-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-brand-800 dark:text-brand-300">Konsultasi Admin</h4>
                    <p class="mt-1 text-xs text-brand-700/70 dark:text-brand-200/70">
                        Hubungi kami via WhatsApp jika aplikasi mengalami kendala teknis.
                    </p>
                </div>
            </a>

            {{-- Kartu WhatsApp Konselor --}}
            <a href="https://wa.me/6285747039355?text=Halo%20Tim%20Konselor%20EMBRACE,%20saya%20ingin%20menjadwalkan%20sesi%20konseling."
                target="_blank" rel="noopener noreferrer"
                class="group flex items-start gap-4 rounded-2xl border border-purple-100 bg-purple-50/50 p-5 hover:bg-purple-100/50 transition-colors dark:border-purple-900/30 dark:bg-purple-900/10 dark:hover:bg-purple-900/20">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-purple-800 dark:text-purple-300">Hubungi Konselor</h4>
                    <p class="mt-1 text-xs text-purple-700/70 dark:text-purple-200/70">
                        Jadwalkan sesi berbincang dengan tenaga ahli di fasilitas kami.
                    </p>
                </div>
            </a>

        </div>

    </div>
@endsection
