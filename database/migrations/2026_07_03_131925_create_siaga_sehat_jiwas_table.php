<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siaga_sehat_jiwas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->restrictOnDelete();
            $table->foreignId('ranting_id')->constrained('rantings')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();

            $table->string('nama_kk', 100);
            $table->unsignedTinyInteger('umur'); // Maksimal nilai 255, sangat cukup untuk umur dan hemat RAM
            $table->enum('status_kawin', ['kawin', 'belum kawin', 'janda', 'duda']);
            $table->enum('pendidikan', ['Tidak sekolah', 'SD', 'SMP', 'SMA', 'PT']);
            $table->string('pekerjaan', 100);
            $table->string('alamat_dusun', 150);
            $table->string('nomor_rumah', 20)->nullable();

            $table->json('indikator_gejala')->nullable();

            $table->enum('status_kesehatan', [
                'Mengalami Gangguan Jiwa',
                'Resiko Masalah Psikososial',
                'Sehat'
            ]);

            $table->timestamps();

            // Composite Indexes untuk optimasi jutaan data
            $table->index(['ranting_id', 'periode_id']); // Filter data per ranting
            $table->index(['periode_id', 'status_kesehatan']); // Kecepatan render chart dashboard superadmin
            $table->index(['nama_kk']); // Kecepatan pencarian (Cursor Pagination)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siaga_sehat_jiwas');
    }
};
