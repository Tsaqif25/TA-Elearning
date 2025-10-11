<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//      public function up(): void
//     {
//         Schema::table('tugas_files', function (Blueprint $table) {
//             // Tambah kolom id auto increment
//             // $table->id()->first();

//             // Pastikan kolom tugas_id sudah unsigned big integer
//             $table->unsignedBigInteger('tugas_id')->change();

//             // Drop foreign key lama (kalau ada)
//             $table->dropForeign(['tugas_id']);

//             // Tambahkan ulang foreign key dengan cascade
//             $table->foreign('tugas_id')
//                 ->references('id')->on('tugas')
//                 ->onDelete('cascade');
//         });
//     }

//     public function down(): void
//     {
//         Schema::table('tugas_files', function (Blueprint $table) {
//             $table->dropColumn('id');
//         });
//     }
// };

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugas_files', function (Blueprint $table) {
            // Tambahkan kolom id jika belum ada
            if (!Schema::hasColumn('tugas_files', 'id')) {
                $table->id()->first();
            }

            // Tambahkan kolom tugas_id jika belum ada
            if (!Schema::hasColumn('tugas_files', 'tugas_id')) {
                $table->unsignedBigInteger('tugas_id')->after('id');
                $table->foreign('tugas_id')
                      ->references('id')
                      ->on('tugas')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tugas_files', function (Blueprint $table) {
            if (Schema::hasColumn('tugas_files', 'id')) {
                $table->dropColumn('id');
            }
            if (Schema::hasColumn('tugas_files', 'tugas_id')) {
                $table->dropForeign(['tugas_id']);
                $table->dropColumn('tugas_id');
            }
        });
    }
};
