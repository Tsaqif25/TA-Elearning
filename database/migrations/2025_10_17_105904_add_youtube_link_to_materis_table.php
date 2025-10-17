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
    Schema::table('materis', function (Blueprint $table) {
        $table->longText('youtube_link')->nullable()->after('content');
    });
}

public function down(): void
{
    Schema::table('materis', function (Blueprint $table) {
        $table->dropColumn('youtube_link');
    });
}
};
