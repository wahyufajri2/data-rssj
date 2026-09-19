<?php

namespace App\Http\Controllers;

use App\Models\PendataanKeluarga;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PendataanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = PendataanKeluarga::query()->with(['user', 'ranting.cabang.daerah'])->select('pendataan_keluargas.*');

            if (Auth::user()->role === 'admin_ranting') {
                $query->where('ranting_id', Auth::user()->ranting_id);
            }
            
            // Add filtering logic here if needed based on the request (e.g., status_kesehatan)

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('no_kk', function($row) {
                    return $row->no_kk;
                })
                ->addColumn('nama_lengkap', function($row) {
                    return $row->nama_lengkap;
                })
                ->addColumn('alamat', function($row) {
                    $alamat = $row->alamat_dusun;
                    if ($row->no_rumah) {
                        $alamat .= ' No. ' . $row->no_rumah;
                    }
                    return $alamat;
                })
                ->addColumn('ranting', function($row) {
                    return $row->ranting->nama_ranting ?? '-';
                })
                ->addColumn('status_kesehatan', function($row) {
                    $status = strtolower($row->status_kesehatan);
                    $badges = [
                        'sehat' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Sehat</span>',
                        'resiko' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>Resiko</span>',
                        'jiwa' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800"><span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>Gangguan Jiwa</span>'
                    ];
                    return $badges[$status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">Unknown</span>';
                })
                ->addColumn('action', function($row) {
                    return view('pendataan.partials.action', compact('row'))->render();
                })
                ->rawColumns(['status_kesehatan', 'action'])
                ->make(true);
        }

        return view('pendataan.index');
    }

    public function create()
    {
        $rantings = \App\Models\Ranting::all();
        return view('pendataan.create', compact('rantings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'status_keluarga' => 'required|string|in:Ayah,Ibu,Anak,Lainnya',
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'status_kawin' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat_dusun' => 'required|string',
            'no_rumah' => 'nullable|string',
            'indikator_gj' => 'nullable|array',
            'indikator_rmp' => 'nullable|array',
            'indikator_rmp_lainnya' => 'nullable|string|max:255',
        ]);

        if (Auth::user()->role === 'superadmin') {
            $request->validate(['ranting_id' => 'required|exists:rantings,id']);
        }

        $periodeAktif = Periode::where('is_active', true)->first();
        if (!$periodeAktif) {
            return back()->withErrors(['message' => 'Tidak ada periode aktif. Hubungi Superadmin.']);
        }

        // Tentukan Status Kesehatan berdasarkan hierarki
        $status_kesehatan = 'sehat';
        if (!empty($validated['indikator_gj']) && count($validated['indikator_gj']) > 0) {
            $status_kesehatan = 'jiwa'; // Prioritas 1
        } elseif (!empty($validated['indikator_rmp']) && count($validated['indikator_rmp']) > 0) {
            $status_kesehatan = 'resiko'; // Prioritas 2
        }

        // Proses "Lainnya" pada indikator_rmp
        $indikator_rmp = $validated['indikator_rmp'] ?? [];
        if (($key = array_search('Lainnya(tulis sendiri)', $indikator_rmp)) !== false) {
            if ($request->filled('indikator_rmp_lainnya')) {
                $indikator_rmp[$key] = 'Lainnya: ' . $request->input('indikator_rmp_lainnya');
            }
        }

        PendataanKeluarga::create([
            'periode_id' => $periodeAktif->id,
            'user_id' => Auth::id(),
            'ranting_id' => Auth::user()->role === 'admin_ranting' ? Auth::user()->ranting_id : $request->input('ranting_id'),
            'no_kk' => $validated['no_kk'],
            'nik' => $validated['nik'],
            'status_keluarga' => $validated['status_keluarga'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'umur' => $validated['umur'],
            'status_kawin' => $validated['status_kawin'],
            'pendidikan' => $validated['pendidikan'],
            'pekerjaan' => $validated['pekerjaan'],
            'alamat_dusun' => $validated['alamat_dusun'],
            'no_rumah' => $validated['no_rumah'] ?? null,
            'indikator_gj' => $validated['indikator_gj'] ?? [],
            'indikator_rmp' => $indikator_rmp,
            'status_kesehatan' => $status_kesehatan,
        ]);

        return redirect()->route('pendataan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $pendataan = PendataanKeluarga::with(['user', 'ranting'])->findOrFail($id);
        
        if (Auth::user()->role === 'admin_ranting' && $pendataan->ranting_id !== Auth::user()->ranting_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pendataan.show', compact('pendataan'));
    }

    public function edit($id)
    {
        $pendataan = PendataanKeluarga::findOrFail($id);

        if (Auth::user()->role === 'admin_ranting' && $pendataan->ranting_id !== Auth::user()->ranting_id) {
            abort(403, 'Unauthorized action.');
        }

        $rantings = \App\Models\Ranting::all();
        return view('pendataan.edit', compact('pendataan', 'rantings'));
    }

    public function update(Request $request, $id)
    {
        $pendataan = PendataanKeluarga::findOrFail($id);

        if (Auth::user()->role === 'admin_ranting' && $pendataan->ranting_id !== Auth::user()->ranting_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'no_kk' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'status_keluarga' => 'required|string|in:Ayah,Ibu,Anak,Lainnya',
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'status_kawin' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat_dusun' => 'required|string',
            'no_rumah' => 'nullable|string',
            'indikator_gj' => 'nullable|array',
            'indikator_rmp' => 'nullable|array',
            'indikator_rmp_lainnya' => 'nullable|string|max:255',
        ]);

        if (Auth::user()->role === 'superadmin') {
            $request->validate(['ranting_id' => 'required|exists:rantings,id']);
            $validated['ranting_id'] = $request->input('ranting_id');
        }

        // Tentukan Status Kesehatan berdasarkan hierarki
        $status_kesehatan = 'sehat';
        if (!empty($validated['indikator_gj']) && count($validated['indikator_gj']) > 0) {
            $status_kesehatan = 'jiwa'; // Prioritas 1
        } elseif (!empty($validated['indikator_rmp']) && count($validated['indikator_rmp']) > 0) {
            $status_kesehatan = 'resiko'; // Prioritas 2
        }

        $validated['status_kesehatan'] = $status_kesehatan;
        
        // Ensure arrays are at least empty array if null
        $validated['indikator_gj'] = $validated['indikator_gj'] ?? [];
        $indikator_rmp = $validated['indikator_rmp'] ?? [];

        // Proses "Lainnya" pada indikator_rmp
        if (($key = array_search('Lainnya(tulis sendiri)', $indikator_rmp)) !== false) {
            if ($request->filled('indikator_rmp_lainnya')) {
                $indikator_rmp[$key] = 'Lainnya: ' . $request->input('indikator_rmp_lainnya');
            }
        }
        
        $validated['indikator_rmp'] = $indikator_rmp;

        $pendataan->update($validated);

        return redirect()->route('pendataan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendataan = PendataanKeluarga::findOrFail($id);

        if (Auth::user()->role === 'admin_ranting' && $pendataan->ranting_id !== Auth::user()->ranting_id) {
            abort(403, 'Unauthorized action.');
        }

        $pendataan->delete();

        return redirect()->route('pendataan.index')->with('success', 'Data berhasil dihapus.');
    }


}
