<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::table('user_tugas_files', function (Blueprint $table) {
    // Tambahkan kolom id kalau belum ada
    if (!Schema::hasColumn('user_tugas_files', 'id')) {
        // $table->id()->first();
    }

    // Kalau FK lama tidak ada, jangan pakai dropForeign (langsung tambahkan)
    if (!Schema::hasColumn('user_tugas_files', 'user_tugas_id')) {
        $table->unsignedBigInteger('user_tugas_id');
    }

    // Tambahkan FK dengan cascade
    // $table->foreign('user_tugas_id')
    //       ->references('id')
    //       ->on('user_tugas')
    //       ->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::table('user_tugas_files', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
};
