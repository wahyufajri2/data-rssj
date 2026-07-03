<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_mandiris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->restrictOnDelete();
            $table->foreignId('ranting_id')->constrained('rantings')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();

            $table->string('nik', 16);
            $table->string('nama', 100);
            $table->date('tanggal_mengisi');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status_perkawinan', ['kawin', 'belum kawin', 'janda', 'duda']);
            $table->unsignedTinyInteger('umur');
            $table->unsignedTinyInteger('jumlah_anak')->default(0);
            $table->enum('pendidikan', ['Tidak sekolah', 'SD', 'SMP', 'SMA', 'PT']);
            $table->string('pekerjaan', 100);
            $table->string('agama', 30);
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat');

            $table->json('jawaban_srq'); // JSON array berisi boolean jawaban ya/tidak
            $table->json('kebiasaan_sehari_hari'); // JSON array berisi enum jawaban kebiasaan

            $table->timestamps();

            $table->index(['ranting_id', 'periode_id']);
            $table->index(['nik']); // Index penting untuk mencegah duplikasi NIK jika nanti dibutuhkan query pencarian
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_mandiris');
    }
};
