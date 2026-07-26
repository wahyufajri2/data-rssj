<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendataan_keluargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ranting_id')->constrained('rantings')->cascadeOnDelete();
            $table->string('nama_kk');
            $table->integer('umur');
            $table->enum('status_kawin', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->enum('pendidikan', ['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'Diploma', 'S1', 'S2', 'S3']);
            $table->string('pekerjaan');
            $table->string('alamat_dusun');
            $table->string('no_rumah')->nullable();
            $table->json('indikator_gj')->nullable();
            $table->json('indikator_rmp')->nullable();
            $table->enum('status_kesehatan', ['jiwa', 'resiko', 'sehat']);
            $table->timestamps();

            $table->index(['ranting_id', 'periode_id', 'status_kesehatan'], 'idx_ranting_periode_status');
            $table->index('status_kesehatan');
            $table->index('periode_id');
            $table->index('ranting_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendataan_keluargas');
    }
};
