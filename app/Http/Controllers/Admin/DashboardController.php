<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Menghitung total pasien (hanya role 'patient')
        $totalPasien = User::where('role', 'patient')->count();

        // Menghitung total sesi skrining yang sudah selesai (memiliki completed_at)
        $sesiSelesai = Screening::whereNotNull('completed_at')->count();

        // Menghitung sesi skrining dengan kategori GAD-7 'berat'
        $cemasBerat = Screening::where('gad_category', 'berat')->count();

        return view('pages.admin.dashboard', [
            'title' => 'Dashboard Admin - EMBRACE',
            'totalPasien' => $totalPasien,
            'sesiSelesai' => $sesiSelesai,
            'cemasBerat' => $cemasBerat,
        ]);
    }
}
