<div class="flex justify-center gap-2">
    <button type="button" 
        x-data="{ 
            cabangId: '{{ $row->id }}', 
            daerahId: '{{ $row->daerah_id }}', 
            nama: '{{ addslashes($row->nama_kecamatan) }}', 
            sk: '{{ addslashes($row->no_sk) }}' 
        }" 
        @click="$dispatch('open-edit-modal', { id: cabangId, daerahId: daerahId, nama: nama, sk: sk })"
        class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 bg-amber-50 dark:bg-amber-900/20 px-3 py-1.5 rounded text-xs font-semibold cursor-pointer">
        Edit
    </button>

    <form action="{{ route('superadmin.cabang.destroy', $row->id) }}" method="POST" class="inline-block" x-data @submit.prevent="Swal.fire({
        title: 'Hapus Cabang?',
        text: 'Apakah Anda yakin ingin menghapus cabang {{ addslashes($row->nama_kecamatan) }}?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827'
    }).then((result) => {
        if (result.isConfirmed) $el.submit();
    })">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 px-3 py-1.5 rounded text-xs font-semibold cursor-pointer">
            Hapus
        </button>
    </form>
</div>
