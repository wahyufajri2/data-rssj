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
        Schema::table('pendataan_keluargas', function (Blueprint $table) {
            $table->string('no_kk')->after('ranting_id');
            $table->string('nik')->after('no_kk');
            $table->enum('status_keluarga', ['Ayah', 'Ibu', 'Anak', 'Lainnya'])->after('nik');
            $table->renameColumn('nama_kk', 'nama_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendataan_keluargas', function (Blueprint $table) {
            $table->dropColumn(['no_kk', 'nik', 'status_keluarga']);
            $table->renameColumn('nama_lengkap', 'nama_kk');
        });
    }
};
