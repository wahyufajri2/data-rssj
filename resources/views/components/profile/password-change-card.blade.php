<div
    class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 shadow-theme-xs bg-white dark:bg-gray-900/50">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white/90 lg:mb-2">
                Ubah Kata Sandi
            </h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Pastikan kata sandi baru Anda minimal 8 karakter dan tidak mudah ditebak.
            </p>
        </div>

        {{-- Mengarahkan form submit sesuai role yang login --}}
        <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.profile.password.update') : route('pasien.profile.password.update') }}"
            method="POST" class="w-full lg:w-1/2">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                {{-- KATA SANDI LAMA --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Kata Sandi Saat Ini
                    </label>
                    <input type="password" name="current_password" required
                        class="h-11 w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-400 focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500 transition-all" />
                    @error('current_password')
                        <span class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- KATA SANDI BARU --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Kata Sandi Baru
                    </label>
                    <input type="password" name="password" required
                        class="h-11 w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-400 focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500 transition-all" />
                    @error('password')
                        <span class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- KONFIRMASI KATA SANDI BARU --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="h-11 w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-400 focus:outline-hidden focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500 transition-all" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="flex w-full sm:w-auto justify-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-brand-600 transition-colors">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>
