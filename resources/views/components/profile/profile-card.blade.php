@use('App\Enums\Role')

@php
    $greeting = \App\Helpers\GreetingHelper::getGreetingData();
    $ucapan = $greeting->ucapan;
    $ikonMatahari = $greeting->ikonMatahari;
    $namaLengkap = $greeting->namaLengkap;
@endphp

<div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
    <div class="flex flex-col gap-6 xl:flex-row xl:items-center">

        <div
            class="flex h-[72px] w-[72px] shrink-0 items-center justify-center rounded-full bg-gray-100 shadow-sm dark:bg-gray-800">
            @if ($ikonMatahari)
                <svg class="text-amber-500" width="34" height="34" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v2" />
                    <path d="M4.93 4.93l1.41 1.41" />
                    <path d="M20 12h2" />
                    <path d="M19.07 4.93l-1.41 1.41" />
                    <path d="M15.947 12.65a4 4 0 0 0-5.925-4.128" />
                    <path d="M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z" />
                </svg>
            @else
                <svg class="text-blue-500 dark:text-blue-400" width="34" height="34" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z" />
                    <path d="M10.083 9A6.002 6.002 0 0 1 16 4a4.243 4.243 0 0 0 2 7.973C18 11.981 18 12 18 12" />
                </svg>
            @endif
        </div>

        <div class="flex-grow text-center xl:text-right">
            <p class="mb-1 text-base font-medium text-gray-500 md:text-lg dark:text-gray-400">
                {{ $ucapan }}
            </p>

            <h2 class="text-2xl font-bold text-gray-800 md:text-3xl lg:text-4xl dark:text-white/90">
                {{ $namaLengkap }}
            </h2>
        </div>
    </div>
</div>
