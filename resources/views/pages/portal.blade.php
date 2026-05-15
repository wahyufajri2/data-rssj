@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative w-full min-h-screen bg-gray-100 dark:bg-gray-900 overflow-y-auto md:overflow-hidden">


        <div class="absolute inset-0 pointer-events-none hidden dark:block">
            <div
                class="absolute top-0 -left-20 w-96 h-96 bg-brand-600/30 rounded-full blur-[100px] animate-blob mix-blend-screen">
            </div>
            <div
                class="absolute top-1/4 right-0 w-[30rem] h-[30rem] bg-brand-600/30 rounded-full blur-[120px] animate-blob delay-2000 mix-blend-screen">
            </div>
            <div
                class="absolute -bottom-100 left-1/3 w-[35rem] h-[35rem] bg-brand-600/30 rounded-full blur-[120px] animate-blob delay-4000 mix-blend-screen">
            </div>
        </div>
        <div class="absolute left-0 top-0 z-0 w-full max-w-[300px] opacity-30 pointer-events-none">
            <img src="{{ asset('images/shape/grid-01.svg') }}" alt="grid" />
        </div>
        <div class="absolute bottom-0 right-0 z-0 w-full max-w-[300px] rotate-180 opacity-30 pointer-events-none">
            <img src="{{ asset('images/shape/grid-01.svg') }}" alt="grid" />
        </div>

        <div class="relative z-10 flex min-h-screen w-full flex-col items-center justify-center p-4">
            {{-- Header --}}
            <div class="mb-10 text-center">
                <a href="https://kemahasiswaan.unisayogya.ac.id/" target="_blank"
                    class="mb-6 inline-block transition-transform hover:scale-105">
                    <img src="{{ asset('images/logo/logo.svg') }}" alt="Logo BKA Dark"
                        class="h-30 w-auto drop-shadow-md block dark:hidden" />

                    <img src="{{ asset('images/logo/logo-dark.svg') }}" alt="Logo BKA Light"
                        class="h-30 w-auto drop-shadow-md hidden dark:block" />
                </a>
                <h1 class="mb-2 text-2xl font-bold text-gray-800 dark:text-white sm:text-4xl tracking-tight">
                    Portal Layanan Kemahasiswaan dan Alumni
                </h1>
                <p class="text-base text-gray-500 dark:text-gray-400">
                    Biro Kemahasiswaan dan Alumni - Universitas 'Aisyiyah Yogyakarta
                </p>
            </div>
            {{-- Cards Container --}}
            <div class="grid w-full max-w-5xl grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {{-- CARD 1: SIM PRESTASI --}}
                <a href="{{ route('login') }}"
                    class="group relative overflow-hidden rounded-2xl bg-white/80 p-8 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:backdrop-blur-md border border-gray-100 hover:border-brand-500 dark:border-white/10">
                    <div
                        class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-brand-500/10 transition-all duration-500 group-hover:scale-150 group-hover:bg-brand-500/20">
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div
                            class="mb-6 rounded-full bg-brand-50 p-4 dark:bg-white/5 text-brand-500 dark:text-brand-400 group-hover:text-brand-600 dark:group-hover:text-white transition-colors">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V9.375a5.375 5.375 0 00-10.75 0V15.375m10.75-3.375H18a4.125 4.125 0 004.125-4.125V6.375m-12 0V3.375m0-1.5h6.75a3 3 0 013 3v2.75" />
                            </svg>
                        </div>
                        <h3
                            class="mb-2 text-xl font-bold text-gray-800 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400">
                            SIM PRESTASI
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Pelaporan, validasi, dan pengelolaan data prestasi non-akademik.
                        </p>
                        <div class="mt-6 inline-flex items-center text-sm font-semibold text-brand-500 dark:text-brand-400">
                            Masuk Aplikasi <span class="ml-2 transition-transform group-hover:translate-x-1">→</span>
                        </div>
                    </div>
                </a>

                {{-- CARD 2: BEASISWA --}}
                <a href="#"
                    class="group relative overflow-hidden rounded-2xl bg-white/80 p-8 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:backdrop-blur-md border border-gray-100 hover:border-green-500 dark:border-white/10">
                    <div
                        class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-green-500/10 transition-all duration-500 group-hover:scale-150 group-hover:bg-green-500/20">
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="mb-6 rounded-full bg-green-50 p-4 dark:bg-white/5 text-green-500 dark:text-green-400">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3
                            class="mb-2 text-xl font-bold text-gray-800 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">
                            LAYANAN BEASISWA
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Informasi penawaran, pendaftaran, dan seleksi beasiswa internal & eksternal.
                        </p>
                        <div class="mt-6 inline-flex items-center text-sm font-semibold text-gray-400 dark:text-gray-500">
                            Segera Hadir
                        </div>
                    </div>
                </a>

                {{-- CARD 3: ORMAWA --}}
                <a href="#"
                    class="group relative overflow-hidden rounded-2xl bg-white/80 p-8 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:backdrop-blur-md border border-gray-100 hover:border-purple-500 dark:border-white/10">
                    <div
                        class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-purple-500/10 transition-all duration-500 group-hover:scale-150 group-hover:bg-purple-500/20">
                    </div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div
                            class="mb-6 rounded-full bg-purple-50 p-4 dark:bg-white/5 text-purple-500 dark:text-purple-400">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <h3
                            class="mb-2 text-xl font-bold text-gray-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">
                            PORTAL ORMAWA
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Administrasi organisasi mahasiswa, pengajuan proposal kegiatan, dan LPJ.
                        </p>
                        <div class="mt-6 inline-flex items-center text-sm font-semibold text-gray-400 dark:text-gray-500">
                            Segera Hadir
                        </div>
                    </div>
                </a>

            </div>

            {{-- Footer (Absolute Bottom) --}}
            <div class="mt-10 md:absolute md:bottom-6 w-full text-center z-10">
                <div class="flex justify-center gap-4 mb-2">
                    <a href="https://www.instagram.com/kemahasiswaanunisa/" target="_blank"
                        class="text-gray-400 hover:text-brand-500 transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="https://kemahasiswaan.unisayogya.ac.id/" target="_blank"
                        class="text-gray-400 hover:text-brand-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </a>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    &copy; {{ date('Y') }} Biro Kemahasiswaan dan Alumni. Universitas 'Aisyiyah Yogyakarta. <br>
                    dikembangkan oleh <a href="https://www.instagram.com/wahyu_fjraz/" target="_blank"
                        class="text-brand-500 hover:underline">IT BKA</a>
                </p>
            </div>

            {{-- Toggler Dark Mode --}}
            <div class="fixed right-6 bottom-6 z-50">
                <button
                    class="bg-brand-500 hover:bg-brand-600 inline-flex size-12 items-center justify-center rounded-full text-white transition-colors shadow-lg"
                    @click.prevent="$store.theme.toggle()">
                    <svg class="hidden fill-current dark:block" width="20" height="20" viewBox="0 0 20 20"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99998 15.7088C10.4142 15.7088 10.75 16.0445 10.75 16.4588V17.7088C10.75 18.123 10.4142 18.4588 9.99998 18.4588C9.58577 18.4588 9.24998 18.123 9.24998 17.7088V16.4588C9.24998 16.0445 9.58577 15.7088 9.99998 15.7088ZM5.96356 15.0972C6.25646 14.8043 6.25646 14.3295 5.96356 14.0366C5.67067 13.7437 5.1958 13.7437 4.9029 14.0366L4.01902 14.9204C3.72613 15.2133 3.72613 15.6882 4.01902 15.9811C4.31191 16.274 4.78679 16.274 5.07968 15.9811L5.96356 15.0972ZM4.29224 10.0001C4.29224 10.4143 3.95645 10.7501 3.54224 10.7501H2.29224C1.87802 10.7501 1.54224 10.4143 1.54224 10.0001C1.54224 9.58592 1.87802 9.25013 2.29224 9.25013H3.54224C3.95645 9.25013 4.29224 9.58592 4.29224 10.0001ZM4.9029 5.9637C5.1958 6.25659 5.67067 6.25659 5.96356 5.9637C6.25646 5.6708 6.25646 5.19593 5.96356 4.90303L5.07968 4.01915C4.78679 3.72626 4.31191 3.72626 4.01902 4.01915C3.72613 4.31204 3.72613 4.78692 4.01902 5.07981L4.9029 5.9637Z"
                            fill="" />
                    </svg>
                    <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"
                            fill="" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection
