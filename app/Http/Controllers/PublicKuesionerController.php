<?php

namespace App\Http\Controllers;

use App\Models\KuesionerMandiri;
use App\Models\Periode;
use App\Models\Ranting;
use Illuminate\Http\Request;

class PublicKuesionerController extends Controller
{
    public function create()
    {
        $rantings = Ranting::all();
        return view('public.kuesioner.create', compact('rantings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ranting_id' => 'required|exists:rantings,id',
            'nama' => 'required|string|max:255',
            'tanggal_mengisi' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'status_kawin' => 'required|string',
            'umur' => 'required|integer|min:0',
            'jumlah_anak' => 'required|integer|min:0',
            'pendidikan' => 'required|string',
            'no_hp' => 'required|string',
            'pekerjaan' => 'required|string',
            'nik' => 'required|string|max:16',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'srq_answers' => 'required|array|size:20', 
            'srq_answers.*' => 'required|integer|in:0,1',
            'kebiasaan_answers' => 'required|array|size:8',
            'kebiasaan_answers.*' => 'required|integer|between:1,4',
        ]);

        $periodeAktif = Periode::where('is_active', true)->first();
        if (!$periodeAktif) {
            return back()->withErrors(['message' => 'Saat ini tidak ada periode pendataan yang aktif. Silakan hubungi admin.']);
        }

        // --- Logika SRQ-20 ---
        $skor_srq = array_sum($validated['srq_answers']);
        $interpretasi_srq = '';
        if ($skor_srq >= 6) {
            $interpretasi_srq = 'KIP-K, Manajemen faktor risiko, Rujukan';
        } else {
            $interpretasi_srq = 'Edukasi (Pola hidup, Relaksasi, Manajemen Stres, Koping)';
        }

        // --- Logika Kebiasaan Sehari-hari ---
        $skor_kebiasaan = array_sum($validated['kebiasaan_answers']);
        $interpretasi_kebiasaan = '';
        if ($skor_kebiasaan >= 25 && $skor_kebiasaan <= 32) {
            $interpretasi_kebiasaan = 'Kebiasaan Baik';
        } elseif ($skor_kebiasaan >= 16 && $skor_kebiasaan <= 24) {
            $interpretasi_kebiasaan = 'Kebiasaan Cukup';
        } else {
            $interpretasi_kebiasaan = 'Kebiasaan Kurang'; // 8-15
        }

        KuesionerMandiri::create([
            'periode_id' => $periodeAktif->id,
            'user_id' => null, // Pengguna umum (publik)
            'ranting_id' => $validated['ranting_id'],
            'nama' => $validated['nama'],
            'tanggal_mengisi' => $validated['tanggal_mengisi'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'status_kawin' => $validated['status_kawin'],
            'umur' => $validated['umur'],
            'jumlah_anak' => $validated['jumlah_anak'],
            'pendidikan' => $validated['pendidikan'],
            'no_hp' => $validated['no_hp'],
            'pekerjaan' => $validated['pekerjaan'],
            'nik' => $validated['nik'],
            'agama' => $validated['agama'],
            'alamat' => $validated['alamat'],
            'skor_srq' => $skor_srq,
            'interpretasi_srq' => $interpretasi_srq,
            'skor_kebiasaan' => $skor_kebiasaan,
            'interpretasi_kebiasaan' => $interpretasi_kebiasaan,
        ]);

        return redirect()->route('public.kuesioner.success')->with([
            'skor_srq' => $skor_srq,
            'interpretasi_srq' => $interpretasi_srq,
            'skor_kebiasaan' => $skor_kebiasaan,
            'interpretasi_kebiasaan' => $interpretasi_kebiasaan,
            'nama' => $validated['nama']
        ]);
    }
}
