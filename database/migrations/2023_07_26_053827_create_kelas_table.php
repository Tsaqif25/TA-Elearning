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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            // Tingkat: X, XI, XII
            $table->enum('tingkat', ['X', 'XI', 'XII']);

            // Jurusan
            $table->enum('jurusan', ['TKJ', 'PPLG', 'MPLB', 'AKL', 'BD', 'BR', 'ULW']);

            // Rombel (nomor kelas)
          $table->unsignedInteger('rombel')->nullable();

            // Nama gabungan (X-TKJ 1), kita generate otomatis
            $table->string('name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
