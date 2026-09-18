@extends('layouts.auth-split')

@section('auth-form')
<div class="w-full max-w-md bg-white/10 dark:bg-gray-800/80 backdrop-blur-lg border border-white/20 dark:border-gray-700/50 p-8 lg:p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] max-h-[90vh] overflow-y-auto custom-scrollbar">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-white">Daftar Admin</h2>
        <p class="text-green-200 dark:text-gray-300 text-sm mt-2">Ajukan akses Admin Ranting baru</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-xl mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.admin.submit') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
        </div>

        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Pilih Ranting</label>
            <div x-data="searchableSelect()" class="relative">
                <!-- Hidden Select for Native Validation & Submission -->
                <select name="ranting_id" x-model="selectedId" required class="absolute inset-0 opacity-0 w-full h-full -z-10 pointer-events-none">
                    <option value="">-- Pilih Wilayah Ranting --</option>
                    @foreach($rantings as $ranting)
                        <option value="{{ $ranting->id }}">{{ $ranting->nama_ranting }}</option>
                    @endforeach
                </select>
                
                <!-- Custom Select Button -->
                <div @click="open = !open" @click.away="open = false" class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all cursor-pointer flex justify-between items-center shadow-inner">
                    <span x-text="selectedName || '-- Pilih Wilayah Ranting --'" :class="{'text-green-300/50': !selectedName}"></span>
                    <svg class="w-4 h-4 text-green-300/50 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="open" x-cloak class="absolute z-50 w-full mt-2 bg-green-800 dark:bg-gray-800 border border-green-500/50 dark:border-gray-600 rounded-xl shadow-2xl overflow-hidden backdrop-blur-lg" x-transition.opacity.duration.200ms>
                    <div class="p-3 border-b border-green-700/50 dark:border-gray-700 bg-green-900/40 dark:bg-gray-900/80">
                        <input type="text" x-model="search" x-ref="searchInput" placeholder="Ketik untuk mencari ranting..." class="w-full px-4 py-2 bg-green-900/50 dark:bg-gray-900 border border-green-500/50 dark:border-gray-500 rounded-lg text-sm text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-inner">
                    </div>
                    <ul class="max-h-56 overflow-y-auto custom-scrollbar py-1">
                        <template x-for="ranting in filteredRantings" :key="ranting.id">
                            <li @click="selectOption(ranting)" class="px-4 py-2.5 cursor-pointer hover:bg-green-700/70 dark:hover:bg-gray-700 text-green-100 dark:text-gray-200 transition-colors flex items-center justify-between" :class="{'bg-green-700 dark:bg-gray-700 font-medium text-yellow-300': selectedId == ranting.id}">
                                <span x-text="ranting.name"></span>
                                <svg x-show="selectedId == ranting.id" class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </li>
                        </template>
                        <li x-show="filteredRantings.length === 0" class="px-4 py-4 text-sm text-green-300/70 dark:text-gray-400 text-center">
                            Tidak ada ranting ditemukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Password</label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" name="password" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-green-300 dark:text-gray-400 hover:text-white">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Konfirmasi Password</label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" name="password_confirmation" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-green-300 dark:text-gray-400 hover:text-white">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
        </div>

        <button type="submit" class="w-full mt-6 bg-yellow-400 text-green-900 font-bold py-3 px-4 rounded-xl hover:bg-yellow-300 transition-colors shadow-lg shadow-yellow-400/20">
            Daftar Sekarang
        </button>
        
        <div class="mt-4 text-center text-sm text-green-200 dark:text-gray-400">
            <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-medium underline transition-colors">&larr; Sudah punya akun? Login di sini</a>
        </div>
    </form>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
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
            @foreach($rantings as $ranting)
                { id: '{{ $ranting->id }}', name: '{!! addslashes($ranting->nama_ranting) !!}' },
            @endforeach
        ],
        init() {
            if (this.selectedId) {
                const found = this.rantings.find(r => r.id == this.selectedId);
                if (found) this.selectedName = found.name;
            }
            // Watch for open state to focus search input
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
