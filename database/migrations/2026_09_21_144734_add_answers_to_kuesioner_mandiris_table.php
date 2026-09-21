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
        Schema::table('kuesioner_mandiris', function (Blueprint $table) {
            $table->json('srq_answers')->nullable()->after('alamat');
            $table->json('kebiasaan_answers')->nullable()->after('interpretasi_srq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuesioner_mandiris', function (Blueprint $table) {
            $table->dropColumn(['srq_answers', 'kebiasaan_answers']);
        });
    }
};
