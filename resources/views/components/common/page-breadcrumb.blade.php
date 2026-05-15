@props([
    'pageTitle' => 'Page',
    'breadcrumbs' => [], // Default kosong agar aman untuk halaman 2 tingkat
])

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    {{-- Judul Besar di Kiri --}}
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        {{ $pageTitle }}
    </h2>

    {{-- Navigasi Breadcrumb di Kanan --}}
    <nav>
        <ol class="flex items-center gap-1.5">

            {{-- LEVEL 1: Home / Root (Selalu Ada) --}}
            <li>
                <a href="/"
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
                    SIM Prestasi
                </a>
            </li>

            {{-- Definisikan Icon Separator Sekali Saja --}}
            @php
                $separator =
                    '<svg class="stroke-current text-gray-400" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" /></svg>';
            @endphp

            {{-- LEVEL TENGAH: Dinamis (Hanya muncul jika ada data di breadcrumbs) --}}
            @foreach ($breadcrumbs as $crumb)
                <li class="flex items-center gap-1.5">
                    {!! $separator !!}
                    <a href="{{ $crumb['url'] }}"
                        class="text-sm text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
                        {{ $crumb['name'] }}
                    </a>
                </li>
            @endforeach

            {{-- LEVEL TERAKHIR: Halaman Aktif (Selalu Ada) --}}
            <li class="flex items-center gap-1.5">
                {!! $separator !!}
                <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                    {{ $pageTitle }}
                </span>
            </li>

        </ol>
    </nav>
</div>
