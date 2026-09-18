@extends('layouts.app')

@section('title', 'Pengguna')
@section('content')
<div class="p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Akun Admin Ranting</h2>
        <div class="flex gap-2">
            <a href="{{ route('register.admin') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Admin Ranting
            </a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode('Halo, silakan daftar sebagai Admin Ranting melalui tautan berikut: ' . url(route('register.admin', [], false))) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.115.548 4.17 1.593 5.992L.2 23.8l5.908-1.55a11.967 11.967 0 005.923 1.564c6.643 0 12.029-5.386 12.029-12.032C24.06 5.385 18.675 0 12.031 0zm0 21.84c-1.782 0-3.525-.48-5.06-1.39l-.36-.213-3.766.988.998-3.67-.234-.373a10.021 10.021 0 01-1.536-5.32c0-5.556 4.52-10.075 10.076-10.075 5.556 0 10.075 4.52 10.075 10.076 0 5.557-4.52 10.075-10.075 10.075zm5.525-7.55c-.303-.152-1.796-.887-2.073-.99-.276-.101-.48-.151-.682.152-.202.303-.782.99-.96 1.192-.176.202-.353.228-.656.076a8.212 8.212 0 01-2.42-1.493 9.074 9.074 0 01-1.674-2.083c-.177-.304-.019-.467.133-.619.136-.137.303-.354.455-.53.151-.177.202-.303.303-.506.1-.202.05-.38-.025-.53-.076-.153-.682-1.646-.934-2.253-.245-.59-.496-.51-.682-.52-.176-.008-.38-.008-.582-.008-.202 0-.53.076-.808.38-.278.304-1.06 1.037-1.06 2.53 0 1.493 1.086 2.936 1.237 3.138.152.203 2.138 3.262 5.176 4.57 2.193.945 2.946.993 3.473.917.59-.085 1.796-.734 2.05-1.442.251-.71.251-1.317.176-1.443-.075-.126-.277-.202-.58-.353z"/>
                </svg>
                Bagikan ke WA
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr class="text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Ranting</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->ranting->nama_ranting ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($user->is_active)
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Tidak Aktif (Menunggu)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <form action="{{ route('superadmin.users.toggle', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded text-sm font-medium transition-colors shadow-sm {{ $user->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 dark:border-red-900/50 dark:bg-red-900/20 dark:hover:bg-red-900/40' : 'bg-emerald-500 hover:bg-emerald-600 text-white border border-transparent' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Setujui (Aktifkan)' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada data Admin Ranting yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
