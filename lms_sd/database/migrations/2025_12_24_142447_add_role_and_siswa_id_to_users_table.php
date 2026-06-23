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
        Schema::table('users', function (Blueprint $table) {
            // 1. Tambah Kolom Role
            $table->enum('role', ['admin', 'guru', 'ortu'])->default('ortu')->after('email');

            // 2. Tambah Kolom Siswa ID (Khusus Ortu)
            // nullable() artinya boleh kosong (untuk admin/guru)
            $table->foreignId('siswa_id')->nullable()->constrained('siswas')->onDelete('cascade')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['role', 'siswa_id']);
        });
    }
};
