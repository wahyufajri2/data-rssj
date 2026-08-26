<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Daerah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Cabang::with('daerah')->select('cabangs.*');
            
            if ($request->filled('daerah_id')) {
                $query->where('daerah_id', $request->daerah_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('daerah_nama', function ($row) {
                    return $row->daerah->nama_kabupaten_kota ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return view('superadmin.cabang.partials.action', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $daerahs = Daerah::all();
        return view('superadmin.cabang.index', compact('daerahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'daerah_id' => 'required|exists:daerahs,id',
            'nama_kecamatan' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
        ]);

        Cabang::create($request->all());

        return redirect()->route('superadmin.cabang.index')->with('success', 'Data Cabang berhasil ditambahkan.');
    }

    public function update(Request $request, Cabang $cabang)
    {
        $request->validate([
            'daerah_id' => 'required|exists:daerahs,id',
            'nama_kecamatan' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
        ]);

        $cabang->update($request->all());

        return redirect()->route('superadmin.cabang.index')->with('success', 'Data Cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        try {
            $cabang->delete();
            return redirect()->route('superadmin.cabang.index')->with('success', 'Data Cabang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.cabang.index')->with('error', 'Gagal menghapus Cabang karena masih memiliki data terkait.');
        }
    }
}
