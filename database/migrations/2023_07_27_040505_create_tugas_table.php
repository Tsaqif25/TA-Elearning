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
        Schema::create('tugas', function (Blueprint $table) {
           $table->id();
 $table->foreignId('kelas_mapel_id')
                ->constrained('kelas_mapels')
                ->onDelete('cascade');
    $table->string('name');
    $table->longText('deskripsi');
    $table->datetime('due')->nullable();
    // UNTUK WAKUR
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
