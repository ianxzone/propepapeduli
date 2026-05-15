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
        Schema::table('journals', function (Blueprint $table) {
            $table->integer('score_emotional')->nullable()->comment('Kesadaran Emosional (1-4)');
            $table->integer('score_perspective')->nullable()->comment('Pengambilan Perspektif (1-4)');
            $table->integer('score_care')->nullable()->comment('Kepedulian Aktif (1-4)');
            $table->integer('score_responsibility')->nullable()->comment('Tanggung Jawab Sosial (1-4)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['score_emotional', 'score_perspective', 'score_care', 'score_responsibility']);
        });
    }
};
