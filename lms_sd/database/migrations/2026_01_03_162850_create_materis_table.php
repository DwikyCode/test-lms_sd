<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('materis', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('deskripsi')->nullable();
        $table->string('link_video'); // Menyimpan link YouTube
        $table->integer('id_kelas');  // Menyimpan ID Kelas
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
