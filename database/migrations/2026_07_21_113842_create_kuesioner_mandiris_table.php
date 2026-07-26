<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuesioner_mandiris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ranting_id')->constrained('rantings')->cascadeOnDelete();
            $table->string('nama');
            $table->date('tanggal_mengisi');
            $table->string('jenis_kelamin');
            $table->string('status_kawin');
            $table->integer('umur');
            $table->integer('jumlah_anak');
            $table->string('pendidikan');
            $table->string('no_hp');
            $table->string('pekerjaan');
            $table->string('nik', 16);
            $table->string('agama');
            $table->text('alamat');
            $table->integer('skor_srq')->nullable();
            $table->text('interpretasi_srq')->nullable();
            $table->integer('skor_kebiasaan')->nullable();
            $table->text('interpretasi_kebiasaan')->nullable();
            $table->timestamps();

            $table->index('nik');
            $table->index('ranting_id');
            $table->index('nama');
            $table->index('periode_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuesioner_mandiris');
    }
};
