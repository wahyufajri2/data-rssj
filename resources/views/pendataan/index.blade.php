@extends('layouts.app')

@section('title', 'Data Pendataan')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Pendataan Keluarga</h2>
        <div class="flex gap-2">

            <a href="{{ route('pendataan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-sm transition-colors shadow-sm">
                Tambah Data
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table id="pendataanTable" class="w-full whitespace-nowrap table-auto text-gray-900 dark:text-gray-100">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr class="text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <th>No</th>
                        <th>Nama KK</th>
                        <th>Ranting</th>
                        <th>Status Kesehatan</th>
                        <th>Alamat</th>
                        <th class="text-center" data-sortable="false">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Data populated by AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#pendataanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pendataan.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_kk', name: 'nama_kk' },
                { data: 'ranting', name: 'ranting.nama_ranting' },
                { data: 'status_kesehatan', name: 'status_kesehatan' },
                { data: 'alamat', name: 'alamat_dusun' }, // or search by both alamat_dusun and no_rumah depending on requirements, but name field matches main column
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: window.dtLangID,
            responsive: true
        });
    });
</script>
@endpush
