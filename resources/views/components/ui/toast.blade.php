@if (session('toast'))
    @php
        $toast = session('toast');
        $colors = [
            'success' => 'bg-green-600',
            'error' => 'bg-red-600',
            'warning' => 'bg-yellow-500',
            'info' => 'bg-blue-600',
        ];
    @endphp

    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50);
    setTimeout(() => show = false, 4000)" x-show="show" x-cloak class="fixed top-5 right-5 z-[99999]"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="opacity-0 translate-x-10 scale-95"
        x-transition:enter-end="opacity-100 translate-x-0 scale-100"
        x-transition:leave="transition transform duration-200"
        x-transition:leave-start="opacity-100 translate-x-0 scale-100"
        x-transition:leave-end="opacity-0 translate-x-10 scale-95">

        <div
            class="{{ $colors[$toast['type']] ?? 'bg-gray-700' }} text-white px-5 py-3 rounded-xl shadow-xl flex items-center gap-3 opacity-85">
            <span class="text-sm font-semibold">{{ $toast['message'] }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white text-lg">×</button>
        </div>
    </div>
@endif
