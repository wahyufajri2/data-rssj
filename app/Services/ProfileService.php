<?php

namespace App\Services;

use App\Models\User;
use App\Enums\Role; 
use Illuminate\Support\Facades\DB;

class ProfileService
{
    public function getContactInfo(User $user): array
    {
        $peranId = $user->peran_id;

        $infoLabel = 'No. HP / Telepon';
        $infoValue = '-';

        if (in_array($peranId, [Role::ADMIN->value, Role::VERIFIKATOR->value])) {
            $infoValue = $user->no_hp ?? '-';

        } elseif ($peranId === Role::MAHASISWA->value) {
            $noTelp = DB::table('v_mahasiswa')
                ->where('email', $user->email)
                ->value('notelpon');

            $infoValue = $noTelp ?? '-';

        } elseif (in_array($peranId, [Role::PIMPINAN->value, Role::PRODI->value, Role::FAKULTAS->value])) {
            $infoLabel = 'NIDN';

            $nidn = DB::table('v_dosen')
                ->where('email', $user->email)
                ->value('nidn');

            $infoValue = $nidn ?? '-';
        }

        return [
            'label' => $infoLabel,
            'value' => $infoValue,
        ];
    }
}
