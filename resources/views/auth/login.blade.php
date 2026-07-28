@extends('layouts.auth-split')

@section('title', 'Login')
@section('auth-form')
<div class="w-full max-w-md bg-white/10 dark:bg-gray-800/80 backdrop-blur-lg border border-white/20 dark:border-gray-700/50 p-8 lg:p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)]">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-700/50 dark:bg-green-600/30 mb-4 border border-green-500/30">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-white">Selamat Datang</h2>
        <p class="text-green-200 dark:text-gray-300 text-sm mt-2">Halaman Masuk Khusus Admin RSSJ</p>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-100 px-4 py-3 rounded-xl mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-xl mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" placeholder="email@contoh.com">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Password</label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" name="password" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-green-300 dark:text-gray-400 hover:text-white">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between text-sm mt-2">
            <label class="flex items-center text-green-200 dark:text-gray-400 cursor-pointer group">
                <div class="relative flex items-center justify-center">
                    <input type="checkbox" name="remember" class="peer sr-only">
                    <div class="w-5 h-5 border-2 border-green-500/50 dark:border-gray-400 rounded bg-green-900/30 dark:bg-gray-900/80 peer-checked:bg-yellow-400 peer-checked:border-yellow-400 dark:peer-checked:bg-yellow-400 dark:peer-checked:border-yellow-400 transition-all duration-200"></div>
                    <svg class="absolute w-3.5 h-3.5 text-green-900 dark:text-gray-900 opacity-0 peer-checked:opacity-100 transition-opacity duration-200 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="ml-3 group-hover:text-white transition-colors duration-200">Ingat Saya</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-yellow-400 hover:text-yellow-300 font-medium transition-colors">Lupa Password?</a>
        </div>

        <button type="submit" class="w-full mt-6 bg-yellow-400 text-green-900 font-bold py-3 px-4 rounded-xl hover:bg-yellow-300 transition-colors shadow-lg shadow-yellow-400/20">
            Masuk ke Dashboard
        </button>
    </form>
</div>
@endsection
