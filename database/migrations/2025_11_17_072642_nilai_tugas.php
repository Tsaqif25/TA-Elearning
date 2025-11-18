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
        Schema::create('nilai_tugas',function(Blueprint $table){
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('data_siswas')->onDelete('cascade');
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
