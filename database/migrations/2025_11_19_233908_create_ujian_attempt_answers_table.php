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
        Schema::create('ujian_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_attempt_id')->constrained('ujian_attempts')->cascadeOnDelete();
            $table->foreignId('soal_ujian_id')->constrained('soal_ujians')->cascadeOnUpdate();
            $table->integer('answer');// opsi yang dipilih siswa
            $table->boolean('is_corret')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_attempt_answers');
    }
};
