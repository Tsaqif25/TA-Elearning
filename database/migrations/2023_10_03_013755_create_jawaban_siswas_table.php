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
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('multiple_id')
                ->constrained('soal_ujian_multiples')
                ->onDelete('cascade');
           $table->foreignId('siswa_id')->constrained('data_siswas')->onDelete('cascade');
            $table->foreignId('soal_ujian_answer_id')
                ->nullable()
                ->constrained('soal_ujian_answers')
                ->onDelete('set null');
            // $table->string('user_jawaban')->nullable(); // dipakai oleh getJawabanMultiple & simpanJawabanMultiple
            $table->decimal('nilai', 6, 2)->nullable(); // dipakai saat penilaian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
