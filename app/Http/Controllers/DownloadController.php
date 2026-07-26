<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranting;
use App\Exports\PendataanExport;
use App\Exports\KuesionerExport;
use App\Exports\GabunganExport;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function index()
    {
        $rantings = [];
        if (Auth::user()->role === 'superadmin') {
            $rantings = Ranting::all();
        }

        return view('downloads.index', compact('rantings'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'jenis_data' => 'required|in:pendataan,kuesioner,semua',
            'ranting_id' => 'nullable|exists:rantings,id'
        ]);

        $jenisData = $request->jenis_data;
        
        // Admin Ranting hanya bisa download data rantingnya sendiri
        $rantingId = Auth::user()->role === 'admin_ranting' ? Auth::user()->ranting_id : $request->ranting_id;
        
        $rantingName = 'Semua Ranting';
        if ($rantingId) {
            $rantingName = Ranting::find($rantingId)->nama_ranting ?? 'Unknown';
            // Membersihkan nama ranting agar aman dijadikan nama file
            $rantingName = preg_replace('/[^A-Za-z0-9\-]/', '_', $rantingName);
        }

        $timestamp = date('Ymd_His');

        if ($jenisData === 'pendataan') {
            $fileName = "Data_Pendataan_RSSJ_{$rantingName}_{$timestamp}.xlsx";
            return (new PendataanExport($rantingId))->download($fileName);
        } elseif ($jenisData === 'kuesioner') {
            $fileName = "Data_Kuesioner_{$rantingName}_{$timestamp}.xlsx";
            return (new KuesionerExport($rantingId))->download($fileName);
        } else {
            $fileName = "Data_Lengkap_RSSJ_{$rantingName}_{$timestamp}.xlsx";
            return (new GabunganExport($rantingId))->download($fileName);
        }
    }
}
