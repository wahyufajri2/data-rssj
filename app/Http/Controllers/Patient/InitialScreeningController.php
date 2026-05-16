<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitialScreeningController extends Controller
{
    /**
     * Menampilkan halaman awal "Bagaimana perasaan Anda hari ini?"
     */
    public function index()
    {
        return view('pages.patient.skrining-awal', [
            'title' => 'Cek Perasaan Hari Ini - EMBRACE'
        ]);
    }

    /**
     * Memproses skor perasaan (0-10) dan mengarahkan pasien
     */
    public function processMood(Request $request)
    {
        $request->validate([
            'mood_score' => ['required', 'integer', 'min:0', 'max:10']
        ]);

        $score = $request->mood_score;

        // Tentukan Kategori VAS
        $vasCategory = 'berat';
        if ($score <= 3) {
            $vasCategory = 'ringan';
        } elseif ($score <= 6) {
            $vasCategory = 'sedang';
        }

        // Jika skor 0-6, sesi dianggap langsung selesai karena tidak ada form lanjutan.
        // Jika 7-10, completed_at dikosongkan karena pasien harus mengisi GAD-7 dulu.
        $completedAt = ($score <= 6) ? now() : null;

        // Simpan ke database
        $screening = Screening::create([
            'user_id'      => Auth::id(),
            'vas_score'    => $score,
            'vas_category' => $vasCategory,
            'started_at'   => now(),
            'completed_at' => $completedAt
        ]);

        // Simpan ID Sesi di session untuk digunakan saat GAD-7 (jika skor >= 7)
        session(['current_screening_id' => $screening->id]);

        // Redirect sesuai skor
        if ($score <= 3) {
            return redirect()->route('pasien.intervensi.ringan')->with('popup', 'Senang melihat kondisi Anda cukup baik hari ini 😊');
        } elseif ($score <= 6) {
            return redirect()->route('pasien.intervensi.sedang');
        } else {
            return redirect()->route('pasien.gad7.form');
        }
    }
}
