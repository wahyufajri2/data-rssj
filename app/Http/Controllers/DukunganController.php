<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Http\Request;

class DukunganController extends Controller
{
    public function index()
    {
        return view('pages.dukungan', [
            'title' => 'Dukungan Sistem'
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'nim'          => 'required|string|max:50',
            'prodi'        => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $urlGambar = '-';
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('dukungan', 'public');
            $urlGambar = asset('storage/' . $path);
        }

        $teksWa = "Halo Admin,\n\n";
        $teksWa .= "Saya membutuhkan bantuan terkait sistem:\n";
        $teksWa .= "Nama: *" . $request->nama . "*\n";
        $teksWa .= "NIM: *" . $request->nim . "*\n";
        $teksWa .= "Prodi: *" . $request->prodi . "*\n\n";
        $teksWa .= "Permasalahan:\n_" . $request->permasalahan . "_\n\n";

        if ($urlGambar !== '-') {
            $teksWa .= "Lampiran Gambar (Silakan klik link di bawah):\n" . $urlGambar;
        }

        $teksWaEncoded = urlencode($teksWa);

        $admin = User::where('peran_id', Role::ADMIN->value)->first();

        $noAdmin = $admin ? $admin->no_hp : '082134910932';

        if ($noAdmin) {
            $noAdmin = preg_replace('/[^0-9]/', '', $noAdmin);

            if (str_starts_with($noAdmin, '0')) {
                $noAdmin = '62' . substr($noAdmin, 1);
            }
        }

        $urlWhatsApp = "https://wa.me/{$noAdmin}?text={$teksWaEncoded}";

        return redirect()->away($urlWhatsApp);
    }
}
