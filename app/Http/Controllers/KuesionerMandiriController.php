<?php

namespace App\Http\Controllers;

use App\Models\KuesionerMandiri;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KuesionerMandiriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = KuesionerMandiri::query()->with(['user', 'ranting.cabang.daerah'])->select('kuesioner_mandiris.*');

            if (Auth::user()->role === 'admin_ranting') {
                $query->where('ranting_id', Auth::user()->ranting_id);
            }
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('nama', function($row) {
                    return $row->nama;
                })
                ->addColumn('ranting', function($row) {
                    return $row->ranting->nama_ranting ?? '-';
                })
                ->addColumn('skor_srq', function($row) {
                    $color = $row->skor_srq >= 6 ? 'red' : 'emerald';
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-'.$color.'-100 text-'.$color.'-800 dark:bg-'.$color.'-900/30 dark:text-'.$color.'-400">'.$row->skor_srq.'</span>';
                })
                ->addColumn('skor_kebiasaan', function($row) {
                    $color = 'gray';
                    if ($row->skor_kebiasaan >= 25) $color = 'emerald';
                    elseif ($row->skor_kebiasaan >= 16) $color = 'amber';
                    else $color = 'red';
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-'.$color.'-100 text-'.$color.'-800 dark:bg-'.$color.'-900/30 dark:text-'.$color.'-400">'.$row->skor_kebiasaan.'</span>';
                })
                ->addColumn('tanggal_mengisi', function($row) {
                    return $row->tanggal_mengisi ? \Carbon\Carbon::parse($row->tanggal_mengisi)->format('d M Y') : '-';
                })
                ->addColumn('action', function($row) {
                    return view('kuesioner.partials.action', compact('row'))->render();
                })
                ->rawColumns(['skor_srq', 'skor_kebiasaan', 'action'])
                ->make(true);
        }

        return view('kuesioner.index');
    }

    public function create()
    {
        $rantings = \App\Models\Ranting::all();
        return view('kuesioner.create', compact('rantings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        if (Auth::user()->role === 'superadmin') {
            $request->validate(['ranting_id' => 'required|exists:rantings,id']);
        }

        $periodeAktif = Periode::where('is_active', true)->first();
        if (!$periodeAktif) {
            return back()->withErrors(['message' => 'Tidak ada periode aktif. Hubungi Superadmin.']);
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
            'user_id' => Auth::id(),
            'ranting_id' => Auth::user()->role === 'admin_ranting' ? Auth::user()->ranting_id : $request->input('ranting_id'),
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

        return redirect()->route('kuesioner.index')->with('success', 'Data kuesioner berhasil disimpan.');
    }


}
