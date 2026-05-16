<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        // Mengambil histori khusus untuk pasien yang sedang login
        $screenings = Screening::with('gadAnswers.question')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.patient.riwayat', compact('screenings'));
    }
}
