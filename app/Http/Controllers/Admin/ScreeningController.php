<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
