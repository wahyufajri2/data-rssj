@extends('layouts.auth-split')

@section('auth-form')
<div class="w-full max-w-md bg-white/10 dark:bg-gray-800/80 backdrop-blur-lg border border-white/20 dark:border-gray-700/50 p-8 lg:p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)]">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-700/50 dark:bg-green-600/30 mb-4 border border-green-500/30">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-white">Lupa Password</h2>
        <p class="text-green-200 dark:text-gray-300 text-sm mt-2">Kirim link reset ke email terdaftar Anda</p>
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

    <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-green-100 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 bg-green-900/30 dark:bg-gray-900/50 border border-green-500/30 dark:border-gray-600 rounded-xl text-white placeholder-green-300/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
        </div>

        <button type="submit" class="w-full mt-6 bg-yellow-400 text-green-900 font-bold py-3 px-4 rounded-xl hover:bg-yellow-300 transition-colors shadow-lg shadow-yellow-400/20">
            Kirim Link Reset
        </button>
        
        <div class="mt-6 text-center text-sm text-green-200 dark:text-gray-400">
            <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-medium underline transition-colors">&larr; Kembali ke Login</a>
        </div>
    </form>
</div>
@endsection
