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
            if (!Schema::hasColumn('modules', 'slug')) {
                $table->string('slug')->after('title')->unique()->nullable();
            }
            if (!Schema::hasColumn('modules', 'content')) {
                $table->json('content')->after('is_active')->nullable();
            }
            if (!Schema::hasColumn('modules', 'badge_name')) {
                $table->string('badge_name')->after('content')->nullable();
            }
            if (!Schema::hasColumn('modules', 'badge_icon')) {
                $table->string('badge_icon')->after('badge_name')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('modules', 'slug')) $cols[] = 'slug';
            if (Schema::hasColumn('modules', 'content')) $cols[] = 'content';
            if (Schema::hasColumn('modules', 'badge_name')) $cols[] = 'badge_name';
            if (Schema::hasColumn('modules', 'badge_icon')) $cols[] = 'badge_icon';
            
            if (count($cols) > 0) {
                $table->dropColumn($cols);
            }
        });
    }
};
