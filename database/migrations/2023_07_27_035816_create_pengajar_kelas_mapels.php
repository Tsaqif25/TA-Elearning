<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('pengajar_kelas_mapels', function (Blueprint $table) {
    $table->id();
    $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
    $table->foreignId('kelas_mapel_id')->constrained('kelas_mapels')->onDelete('cascade');
    $table->timestamps();
    $table->unique(['guru_id', 'kelas_mapel_id']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('pengajar_kelas_mapels');
    }
};
