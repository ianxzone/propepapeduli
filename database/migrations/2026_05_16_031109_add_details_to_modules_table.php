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
        Schema::table('modules', function (Blueprint $table) {
            $table->string('slug')->after('title')->unique()->nullable(); // nullable temporarily to avoid issues if data exists
            $table->json('content')->after('is_active')->nullable();
            $table->string('badge_name')->after('content')->nullable();
            $table->string('badge_icon')->after('badge_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['slug', 'content', 'badge_name', 'badge_icon']);
        });
    }
};
