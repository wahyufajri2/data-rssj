@extends('layouts.patient')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <x-common.page-breadcrumb pageTitle="Profil Saya" />

        {{-- MENGUBAH session('success') MENJADI session('status') --}}
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition.duration.500ms
                class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profil</h3>

            <x-profile.profile-card />

            {{-- MENGGANTI VARIABEL YANG HILANG DENGAN DATA LANGSUNG DARI $user --}}
            <x-profile.personal-info-card infoLabel="Nomor HP" :infoValue="$user->no_hp ?? '-'" />

            <x-profile.password-change-card />
            {{-- <x-profile.address-card /> --}}

        </div>
    </div>
@endsection
