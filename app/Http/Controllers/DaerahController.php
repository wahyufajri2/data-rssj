<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    public function index()
    {
        $daerahs = Daerah::all();
        return view('superadmin.daerah.index', compact('daerahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kabupaten_kota' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
            'nama_wilayah' => 'required|string|max:255',
        ]);

        Daerah::create($request->all());

        return redirect()->route('superadmin.daerah.index')->with('success', 'Data Daerah berhasil ditambahkan.');
    }

    public function update(Request $request, Daerah $daerah)
    {
        $request->validate([
            'nama_kabupaten_kota' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
            'nama_wilayah' => 'required|string|max:255',
        ]);

        $daerah->update($request->all());

        return redirect()->route('superadmin.daerah.index')->with('success', 'Data Daerah berhasil diperbarui.');
    }

    public function destroy(Daerah $daerah)
    {
        try {
            $daerah->delete();
            return redirect()->route('superadmin.daerah.index')->with('success', 'Data Daerah berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.daerah.index')->with('error', 'Gagal menghapus Daerah karena masih memiliki data terkait.');
        }
    }
}
