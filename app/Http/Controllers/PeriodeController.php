<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderBy('tahun', 'desc')->get();
        return view('superadmin.periode.index', compact('periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|digits:4|unique:periodes,tahun',
        ], [
            'tahun.unique' => 'Tahun periode tersebut sudah ada di sistem.',
        ]);

        Periode::create([
            'tahun' => $request->tahun,
            'is_active' => false, // Default tidak aktif
        ]);

        return back()->with('success', 'Periode tahun ' . $request->tahun . ' berhasil ditambahkan.');
    }

    public function toggleActive(Periode $periode)
    {
        // Jika periode tersebut sudah aktif, jangan lakukan apa-apa
        if ($periode->is_active) {
            return back()->with('info', 'Periode ini sudah aktif.');
        }

        DB::transaction(function () use ($periode) {
            // Nonaktifkan semua periode
            Periode::where('is_active', true)->update(['is_active' => false]);
            
            // Aktifkan periode yang dipilih
            $periode->update(['is_active' => true]);
        });

        return back()->with('success', 'Periode tahun ' . $periode->tahun . ' berhasil diaktifkan.');
    }

    public function destroy(Periode $periode)
    {
        if ($periode->is_active) {
            return back()->withErrors(['message' => 'Tidak dapat menghapus periode yang sedang aktif! Aktifkan periode lain terlebih dahulu.']);
        }

        // Cek relasi jika diperlukan (misal ke Pendataan), tapi untuk sekarang hapus saja
        $periode->delete();

        return back()->with('success', 'Periode tahun ' . $periode->tahun . ' berhasil dihapus.');
    }
}
