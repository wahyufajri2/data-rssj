<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GadQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GadQuestionController extends Controller
{
    /**
     * Menampilkan daftar pertanyaan GAD-7
     */
    public function index(): View
    {
        $questions = GadQuestion::orderBy('order_num', 'asc')->get();

        return view('pages.admin.gad.index', [
            'title' => 'Kelola Pertanyaan GAD-7 - EMBRACE',
            'questions' => $questions
        ]);
    }

    /**
     * Menyimpan pertanyaan GAD-7 baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Tambahkan validasi unique ke tabel gad_questions kolom order_num
            'order_num' => ['required', 'integer', 'min:1', Rule::unique('gad_questions', 'order_num')],
            'question'  => ['required', 'string', 'max:500'],
        ], [
            'order_num.required' => 'Nomor urut wajib diisi.',
            'order_num.unique'   => 'Nomor urut ini sudah digunakan. Silakan gunakan nomor urut yang lain.',
            'question.required'  => 'Teks pertanyaan wajib diisi.',
        ]);

        GadQuestion::create([
            'order_num' => $request->order_num,
            'question'  => $request->question,
            'is_active' => true,
        ]);

        $safeQuestion = e($request->question);
        // Menyisipkan variabel teks pertanyaan ke dalam pesan sukses
        return back()->with('success', "Pertanyaan <strong>\"" . Str::limit($safeQuestion, 50) . "\"</strong> berhasil ditambahkan.");
    }

    /**
     * Memperbarui data pertanyaan GAD-7 yang sudah ada.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            // Sama seperti store, tapi kecualikan ID pertanyaan yang sedang diedit ini
            'order_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('gad_questions', 'order_num')->ignore($id)
            ],
            'question'  => ['required', 'string', 'max:500'],
        ], [
            'order_num.unique' => 'Nomor urut ini sudah digunakan oleh pertanyaan lain.',
        ]);

        $gadQuestion = GadQuestion::findOrFail($id);

        $gadQuestion->update([
            'order_num' => $request->order_num,
            'question'  => $request->question,
        ]);

        $safeQuestion = e($request->question);
        return back()->with('success', "Teks pertanyaan <strong>\"" . Str::limit($safeQuestion, 50) . "\"</strong> berhasil diperbarui.");
    }

    /**
     * Memperbarui status aktif/non-aktif pertanyaan.
     */
    public function toggleStatus(Request $request, $id): RedirectResponse
    {
        $gadQuestion = GadQuestion::findOrFail($id);

        $gadQuestion->update([
            'is_active' => !$gadQuestion->is_active
        ]);

        $status = $gadQuestion->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pertanyaan berhasil {$status}.");
    }
}
