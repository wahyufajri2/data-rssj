<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\GadQuestion;
use App\Models\Screening;
use App\Models\ScreeningGadAnswer;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Menampilkan halaman Intervensi Ringan (Skor 0-3)
     */
    public function ringan()
    {
        return view('pages.patient.intervensi.ringan', [
            'title' => 'Intervensi Ringan - EMBRACE'
        ]);
    }

    /**
     * Menampilkan halaman Intervensi Sedang (Skor 4-6)
     */
    public function sedang()
    {
        return view('pages.patient.intervensi.sedang', [
            'title' => 'Intervensi Sedang - EMBRACE'
        ]);
    }

    /**
     * Menampilkan Form Evaluasi GAD-7 (Skor 7-10)
     */
    public function gad7Form()
    {
        // Ambil semua pertanyaan yang aktif, urutkan berdasarkan order_num
        $questions = GadQuestion::where('is_active', true)->orderBy('order_num', 'asc')->get();

        return view('pages.patient.gad7.form', [
            'title' => 'Evaluasi Lanjutan GAD-7 - EMBRACE',
            'questions' => $questions
        ]);
    }

    /**
     * Memproses jawaban kuesioner GAD-7 dan menentukan intervensi lanjutan
     */
    public function processGad7(Request $request)
    {
        $request->validate([
            'answers'   => ['required', 'array'],
            'answers.*' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $answers = $request->input('answers');
        $totalScore = array_sum($answers);

        // Tentukan Kategori GAD-7
        $gadCategory = 'berat';
        if ($totalScore <= 9) {
            $gadCategory = 'ringan';
        } elseif ($totalScore <= 14) {
            $gadCategory = 'sedang';
        }

        // 1. Ambil ID Screening yang tadi dibuat di Dashboard
        $screeningId = session('current_screening_id');

        if ($screeningId) {
            $screening = Screening::find($screeningId);

            if ($screening) {
                // Update skor GAD, Kategori GAD, dan tandai waktu selesai
                $screening->update([
                    'gad_score'    => $totalScore,
                    'gad_category' => $gadCategory,
                    'completed_at' => now(),
                ]);

                // 2. Simpan detail tiap jawaban ke tabel relasi
                foreach ($answers as $questionId => $answerValue) {
                    ScreeningGadAnswer::create([
                        'screening_id'    => $screening->id,
                        'gad_question_id' => $questionId,
                        'score'           => $answerValue // Sesuai kolom di migrasi Anda
                    ]);
                }
            }

            // Hapus session karena alur skrining sudah benar-benar selesai
            session()->forget('current_screening_id');
        }

        // 3. Tentukan rute Intervensi GAD
        if ($gadCategory === 'ringan') {
            return redirect()->route('pasien.gad7.ringan');
        } elseif ($gadCategory === 'sedang') {
            return redirect()->route('pasien.gad7.sedang');
        } else {
            return redirect()->route('pasien.gad7.berat');
        }
    }

    /**
     * Menampilkan halaman Intervensi GAD-7 Ringan
     */
    public function gad7Ringan()
    {
        return view('pages.patient.gad7.ringan', [
            'title' => 'Intervensi Ringan - EMBRACE'
        ]);
    }

    /**
     * Menampilkan halaman Intervensi GAD-7 Sedang
     */
    public function gad7Sedang()
    {
        return view('pages.patient.gad7.sedang', [
            'title' => 'Intervensi Sedang - EMBRACE'
        ]);
    }

    /**
     * Menampilkan halaman Intervensi GAD-7 Berat
     */
    public function gad7Berat()
    {
        return view('pages.patient.gad7.berat', [
            'title' => 'Intervensi Lanjutan - EMBRACE'
        ]);
    }
}
