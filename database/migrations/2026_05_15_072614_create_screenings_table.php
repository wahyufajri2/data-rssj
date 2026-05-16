<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Master Pertanyaan GAD
        // Memungkinkan admin mengedit teks atau menambah pertanyaan tanpa coding
        Schema::create('gad_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->integer('order_num')->unique()->comment('Urutan tampil pertanyaan, tidak boleh duplikat');
            $table->boolean('is_active')->default(true)->comment('Status aktif agar admin bisa menonaktifkan pertanyaan lama tanpa menghapus histori');
            $table->timestamps();
        });

        // 2. Tabel Histori Sesi Skrining (Tabel Utama)
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tahap 1: VAS (Visual Analogue Scale)
            $table->integer('vas_score')->comment('Skor cek perasaan awal (0-10)');
            $table->enum('vas_category', ['ringan', 'sedang', 'berat'])->comment('Kategori dari skor VAS');

            // Tahap 2: GAD-7 (Kosong jika VAS < 7)
            $table->integer('gad_score')->nullable()->comment('Total Skor GAD-7');
            $table->enum('gad_category', ['ringan', 'sedang', 'berat'])->nullable()->comment('Kategori dari total skor GAD-7');

            // Pelacakan Sesi (Penting untuk histori)
            $table->timestamp('started_at')->useCurrent()->comment('Waktu saat pasien mulai memilih VAS 0-10');
            $table->timestamp('completed_at')->nullable()->comment('Waktu saat pasien mengklik tombol Akhiri Sesi');

            $table->timestamps();
        });

        // 3. Tabel Detail Jawaban GAD (Relasi Many-to-Many)
        // Menggantikan kolom json('gad_answers')
        Schema::create('screening_gad_answers', function (Blueprint $table) {
            $table->id();

            // Relasi ke sesi skrining spesifik
            $table->foreignId('screening_id')->constrained('screenings')->onDelete('cascade');

            // Relasi ke pertanyaan yang dijawab
            $table->foreignId('gad_question_id')->constrained('gad_questions')->onDelete('cascade');

            // Jawaban pasien
            $table->integer('score')->comment('Skor jawaban (0: Tidak Pernah, 1: Beberapa Hari, 2: Lebih dari 7 Hari, 3: Hampir Setiap Hari)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Urutan drop harus dari bawah ke atas untuk menghindari error foreign key
        Schema::dropIfExists('screening_gad_answers');
        Schema::dropIfExists('screenings');
        Schema::dropIfExists('gad_questions');
    }
};
