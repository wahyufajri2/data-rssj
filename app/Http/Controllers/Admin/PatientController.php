<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Menampilkan daftar semua pasien.
     */
    public function index(): View
    {
        // Mengambil semua user dengan role 'patient', diurutkan dari yang terbaru
        $patients = User::where('role', 'patient')->latest()->paginate(10);

        return view('pages.admin.patient.index', [
            'title' => 'Data Pasien - EMBRACE',
            'patients' => $patients
        ]);
    }
}
