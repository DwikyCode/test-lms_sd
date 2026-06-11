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
    Schema::create('nilais', function (Blueprint $table) {
        $table->id();
        $table->string('kelas');
        $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
        $table->string('mapel'); 

        // Detail Nilai (Default 0 biar gak error kalau kosong)
        $table->integer('tugas1')->default(0);
        $table->integer('tugas2')->default(0);
        $table->integer('tugas3')->default(0);
        $table->integer('tugas4')->default(0);
        $table->integer('kuis1')->default(0);
        $table->integer('kuis2')->default(0);

        // Nilai Akhir
        $table->integer('tugas')->default(0);
        $table->integer('uts')->default(0);
        $table->integer('uas')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
