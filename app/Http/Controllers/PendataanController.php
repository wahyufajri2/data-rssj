<?php

namespace App\Http\Controllers;

use App\Models\PendataanKeluarga;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendataanController extends Controller
{
    public function index(Request $request)
    {
        $query = PendataanKeluarga::query()->with(['user', 'ranting']);

        if (Auth::user()->role === 'admin_ranting') {
            $query->where('ranting_id', Auth::user()->ranting_id);
        }

        $data = $query->latest()->cursorPaginate(50);

        return view('pendataan.index', compact('data'));
    }

    public function create()
    {
        $rantings = \App\Models\Ranting::all();
        return view('pendataan.create', compact('rantings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kk' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'status_kawin' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat_dusun' => 'required|string',
            'no_rumah' => 'nullable|string',
            'indikator_gj' => 'nullable|array',
            'indikator_rmp' => 'nullable|array',
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

        PendataanKeluarga::create([
            'periode_id' => $periodeAktif->id,
            'user_id' => Auth::id(),
            'ranting_id' => Auth::user()->role === 'admin_ranting' ? Auth::user()->ranting_id : $request->input('ranting_id'),
            'nama_kk' => $validated['nama_kk'],
            'umur' => $validated['umur'],
            'status_kawin' => $validated['status_kawin'],
            'pendidikan' => $validated['pendidikan'],
            'pekerjaan' => $validated['pekerjaan'],
            'alamat_dusun' => $validated['alamat_dusun'],
            'no_rumah' => $validated['no_rumah'] ?? null,
            'indikator_gj' => $validated['indikator_gj'] ?? [],
            'indikator_rmp' => $validated['indikator_rmp'] ?? [],
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
            'nama_kk' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'status_kawin' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat_dusun' => 'required|string',
            'no_rumah' => 'nullable|string',
            'indikator_gj' => 'nullable|array',
            'indikator_rmp' => 'nullable|array',
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
        $validated['indikator_rmp'] = $validated['indikator_rmp'] ?? [];

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
