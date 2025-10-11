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
        Schema::create('tugas_files', function (Blueprint $table) {
            $table->id(); // Primary key

            // Tambahkan kolom tugas_id lalu jadikan foreign key
            $table->foreignId('tugas_id')
                  ->constrained('tugas') // sesuaikan dengan nama tabel utama
                  ->onDelete('cascade');

            $table->string('file');
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_files');
    }
};
