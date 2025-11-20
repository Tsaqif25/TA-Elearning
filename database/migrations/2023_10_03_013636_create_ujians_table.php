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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_mapel_id')
                ->constrained('kelas_mapels')
                ->onDelete('cascade');
             $table->foreignId('guru_id')
            ->constrained('gurus')
            ->cascadeOnDelete();
            $table->string('judul');
           $table->text('deskripsi')->nullable();
           $table->integer('durasi_menit');
           $table->boolean('random_question')->default(true);
           $table->boolean('random_answer')->default(true);
           $table->boolean('show_answer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
