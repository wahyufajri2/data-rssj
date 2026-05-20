<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HistoriSkriningExport;
use App\Http\Controllers\Controller;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ScreeningController extends Controller
{
    /**
     * Menampilkan daftar riwayat skrining semua pasien.
     */
    public function index(): View
    {
        // Mengambil semua data skrining, diurutkan dari yang terbaru,
        // beserta data relasi 'user' (pasien yang melakukan skrining).
        // Hanya ambil yang statusnya sudah selesai (completed_at tidak null)
        $screenings = Screening::with('user')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->paginate(15);

        return view('pages.admin.screening.index', [
            'title' => 'Histori Skrining GAD-7 - EMBRACE',
            'screenings' => $screenings
        ]);
    }

    public function export(Request $request)
    {
        // Mengumpulkan filter aktif untuk dilempar ke file Export
        $filters = [
            'search'     => $request->input('search'),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ];

        $namaFile = 'Histori_Skrining_EMBRACE_' . date('Y-m-d_H-i-s') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new HistoriSkriningExport($filters), $namaFile);
    }
}
