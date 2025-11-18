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
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
    $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
    $table->foreignId('siswa_id')->constrained('data_siswas')->onDelete('cascade');
    $table->dateTime('submitted_at')->nullable();
    $table->boolean('is_late')->default(false);
 
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
