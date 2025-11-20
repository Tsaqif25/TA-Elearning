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
        Schema::create('soal_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujians')->cascadeOnDelete();
            $table->text('pertanyaan');
             $table->text('option_1')->nullable();
        $table->text('option_2')->nullable();
        $table->text('option_3')->nullable();
        $table->text('option_4')->nullable();
        $table->text('option_5')->nullable();

        $table->integer('answer'); // nomor opsi benar (1–5)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_ujians');
    }
};
