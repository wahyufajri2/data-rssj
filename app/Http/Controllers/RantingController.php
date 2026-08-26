<?php

namespace App\Http\Controllers;

use App\Models\Ranting;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RantingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ranting::with('cabang.daerah')->select('rantings.*');
            
            if ($request->filled('daerah_id')) {
                $query->whereHas('cabang', function($q) use ($request) {
                    $q->where('daerah_id', $request->daerah_id);
                });
            }
            
            if ($request->filled('cabang_id')) {
                $query->where('cabang_id', $request->cabang_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('daerah_nama', function ($row) {
                    return $row->cabang->daerah->nama_kabupaten_kota ?? '-';
                })
                ->addColumn('cabang_nama', function ($row) {
                    return $row->cabang->nama_kecamatan ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return view('superadmin.ranting.partials.action', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $cabangs = Cabang::with('daerah')->get();
        $daerahs = \App\Models\Daerah::all();
        
        $cabangFilterQuery = Cabang::query();
        if ($request->filled('daerah_id')) {
            $cabangFilterQuery->where('daerah_id', $request->daerah_id);
        }
        $cabangsFilter = $cabangFilterQuery->get();

        return view('superadmin.ranting.index', compact('cabangs', 'daerahs', 'cabangsFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'nama_ranting' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
        ]);

        Ranting::create($request->all());

        return redirect()->route('superadmin.ranting.index')->with('success', 'Data Ranting berhasil ditambahkan.');
    }

    public function update(Request $request, Ranting $ranting)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'nama_ranting' => 'required|string|max:255',
            'no_sk' => 'required|string|max:255',
        ]);

        $ranting->update($request->all());

        return redirect()->route('superadmin.ranting.index')->with('success', 'Data Ranting berhasil diperbarui.');
    }

    public function destroy(Ranting $ranting)
    {
        try {
            $ranting->delete();
            return redirect()->route('superadmin.ranting.index')->with('success', 'Data Ranting berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.ranting.index')->with('error', 'Gagal menghapus Ranting karena masih memiliki data terkait.');
        }
    }
}
