@extends('layouts.auth-split')

@section('title', 'Verifikasi Email')
@section('auth-form')
<div class="w-full max-w-md bg-white/10 dark:bg-gray-800/80 backdrop-blur-lg border border-white/20 dark:border-gray-700/50 p-8 lg:p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)]">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-400/20 mb-4 border border-yellow-400/50">
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-white">Verifikasi Email</h2>
        <p class="text-green-200 dark:text-gray-300 text-sm mt-3 leading-relaxed">
            Terima kasih! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan melalui email? Jika Anda tidak menerima email tersebut, silakan klik tombol di bawah untuk mengirim ulang.
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-100 px-4 py-3 rounded-xl mb-6 text-sm text-center font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-8 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="bg-yellow-400 text-green-900 font-bold py-2.5 px-6 rounded-xl hover:bg-yellow-300 transition-colors shadow-lg shadow-yellow-400/20 text-sm cursor-pointer">
                Kirim Ulang Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-green-200 hover:text-white dark:text-gray-400 dark:hover:text-white underline text-sm transition-colors cursor-pointer">
                Keluar
            </button>
        </form>
    </div>
</div>
@endsection
