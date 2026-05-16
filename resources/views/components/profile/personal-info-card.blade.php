<div
    class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 shadow-theme-xs bg-white dark:bg-gray-900/50">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div class="w-full">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white/90 lg:mb-6">
                Informasi Pribadi
            </h4>

            {{-- Grid Informasi Pribadi (Hanya menampilkan data yang ada di DB) --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-7">

                {{-- NAMA --}}
                <div>
                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Nama Lengkap</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->name ?? '-' }}
                    </p>
                </div>

                {{-- NOMOR HP --}}
                <div>
                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">No.
                        Handphone</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->no_hp ?? '-' }}
                    </p>
                </div>

                {{-- EMAIL --}}
                <div>
                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Email</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->email ?? 'Belum ditambahkan' }}
                    </p>
                </div>

                {{-- ROLE --}}
                <div>
                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Peran Akun</p>
                    <div
                        class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-bold text-brand-600 dark:bg-brand-900/30 dark:text-brand-400">
                        {{ ucfirst(Auth::user()->role) }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Tombol Edit --}}
        <button
            class="shrink-0 flex items-center gap-1.5 rounded-lg bg-gray-50 px-4 py-2 text-sm font-semibold text-brand-600 transition-colors hover:bg-brand-50 hover:text-brand-700 dark:bg-gray-800 dark:text-brand-400 dark:hover:bg-brand-900/30 dark:hover:text-brand-300 border border-gray-200 dark:border-gray-700"
            @click="$dispatch('open-profile-info-modal')">
            <svg class="h-4 w-4 fill-current" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z" />
            </svg>
            Edit Data
        </button>
    </div>
</div>

{{-- MODAL EDIT INFORMASI PRIBADI --}}
<x-ui.modal x-data="{ open: false }" @open-profile-info-modal.window="open = true" :isOpen="false" class="max-w-2xl">
    <div
        class="no-scrollbar relative w-full max-w-2xl overflow-y-auto rounded-3xl bg-white p-5 dark:bg-gray-900 sm:p-8">

        <div class="mb-6">
            <h4 class="text-xl font-bold text-gray-900 dark:text-white sm:text-2xl">
                Edit Informasi Pribadi
            </h4>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Perbarui detail akun Anda di bawah ini.
            </p>
        </div>

        {{-- Route Update Dinamis berdasarkan Role --}}
        <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.profile.update') : route('pasien.profile.update') }}"
            method="POST" class="flex flex-col">
            @csrf
            @method('PUT')

            <div class="space-y-5">

                {{-- NAMA LENGKAP --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="h-11 w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-400 focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500 transition-all" />
                    @error('name')
                        <span class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- GRID UNTUK NO HP & EMAIL --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    {{-- NO HANDPHONE --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            No. Handphone
                        </label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp) }}" required
                            class="h-11 w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-400 focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500 transition-all" />
                        @error('no_hp')
                            <span class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- EMAIL ADDRESS --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Email <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                            class="h-11 w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-400 focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500 transition-all" />
                        @error('email')
                            <span class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="mt-8 flex flex-col-reverse items-center gap-3 sm:flex-row sm:justify-end">
                <button @click="open = false" type="button"
                    class="flex w-full sm:w-auto justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors shadow-theme-xs">
                    Batal
                </button>
                <button type="submit"
                    class="flex w-full sm:w-auto justify-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-brand-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-ui.modal>
