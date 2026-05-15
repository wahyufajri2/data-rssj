@props(['infoLabel', 'infoValue'])
@use('App\Enums\Role')

{{-- BANNER INTEGRASI SIMPTT --}}
@if (!in_array(Auth::user()->peran_id, [Role::ADMIN->value, Role::VERIFIKATOR->value]))
    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/30">
        <div class="flex items-start gap-3">
            <div class="mt-0.5 text-blue-600 dark:text-blue-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h5 class="text-sm font-semibold text-blue-800 dark:text-blue-300">Integrasi SIMPTT</h5>
                <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                    Khusus Dosen dan Mahasiswa, data profil Anda terintegrasi langsung secara otomatis. Untuk
                    memperbarui informasi seperti No. HP atau email atau Rekening, silakan ubah melalui portal
                    <strong>SIMPTT</strong> ( <a href="https://sim.unisayogya.ac.id/simptt-mahasiswa/" target="_blank"
                        class="font-bold underline hover:text-blue-900 dark:hover:text-blue-200">klik di sini</a>)
                    . Data di sini akan diperbarui
                    saat Anda login kembali.
                </p>
            </div>
        </div>
    </div>
@endif

<div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div class="w-full">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                Informasi Pribadi
            </h4>

            {{-- Menambahkan lg:grid-cols-3 agar layout lebih lega karena datanya bertambah --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-7 2xl:gap-x-32">
                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->fullname ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Email</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->email ?? (session('email') ?? '-') }}
                    </p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                        {{ $infoLabel }}
                    </p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ $infoValue }}
                    </p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Peran</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Str::title(Auth::user()->peran->nama_peran ?? 'Peran Tidak Diketahui') }}
                    </p>
                </div>

                {{-- Tampilan Rekening Baru --}}
                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">No. Rekening</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->no_rekening ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Nama Bank</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ Auth::user()->nama_rekening ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        @if (in_array(Auth::user()->peran_id, [Role::ADMIN->value, Role::VERIFIKATOR->value]))
            <button class="shrink-0 edit-button" @click="$dispatch('open-profile-info-modal')">
                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                        fill="" />
                </svg>
                Edit
            </button>
        @endif

    </div>
</div>

{{-- MODAL EDIT (Hanya bisa dibuka oleh Admin & Verifikator) --}}
<x-ui.modal x-data="{ open: false }" @open-profile-info-modal.window="open = true" :isOpen="false"
    class="max-w-[700px]">
    <div
        class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
        <div class="px-2 pr-14">
            <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                Edit Informasi Pribadi
            </h4>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                Perbarui detail Anda untuk menjaga profil Anda tetap terbaru.
            </p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col">
            @csrf
            @method('PUT')

            <div class="custom-scrollbar h-auto max-h-[458px] overflow-y-auto p-2">
                <div class="mt-2">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">

                        <div class="col-span-1 lg:col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Lengkap
                            </label>
                            <input type="text" name="fullname" value="{{ old('fullname', Auth::user()->fullname) }}"
                                required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            @error('fullname')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email Address
                            </label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                required
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            @error('email')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                No. Handphone
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp) }}"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            @error('no_hp')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input Rekening & Bank --}}
                        <div class="col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                No. Rekening
                            </label>
                            <input type="text" name="no_rekening"
                                value="{{ old('no_rekening', Auth::user()->no_rekening) }}"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            @error('no_rekening')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Bank
                            </label>
                            <input type="text" name="nama_rekening"
                                value="{{ old('nama_rekening', Auth::user()->nama_rekening) }}"
                                placeholder="Contoh: BNI, Mandiri, BSI"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            @error('nama_rekening')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                <button @click="open = false" type="button"
                    class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                    Tutup
                </button>
                <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-ui.modal>
