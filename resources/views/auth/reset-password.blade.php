@extends('layouts.auth-split')

@section('auth-form')
<div class="w-full max-w-md bg-white/10 dark:bg-gray-800/80 backdrop-blur-lg border border-white/20 dark:border-gray-700/50 p-8 lg:p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)]">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-white">Reset Password</h2>
        <p class="text-green-200 dark:text-gray-300 text-sm mt-2">Silakan buat password baru Anda</p>
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

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ request()->email ?? old('email') }}" required readonly class="w-full px-4 py-3 bg-green-900/50 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-green-300 focus:outline-none cursor-not-allowed">
        </div>

        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Password Baru</label>
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
            Simpan Password Baru
        </button>
    </form>
</div>
@endsection
