<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin_ranting'])->default('admin_ranting')->after('password');
            $table->foreignId('ranting_id')->nullable()->after('role')->constrained('rantings')->restrictOnDelete();
            $table->boolean('is_approved')->default(false)->after('ranting_id');

            // Index untuk kecepatan query superadmin saat memfilter user
            $table->index(['role', 'is_approved']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ranting_id']);
            $table->dropIndex(['role', 'is_approved']);
            $table->dropColumn(['role', 'ranting_id', 'is_approved']);
        });
    }
};
