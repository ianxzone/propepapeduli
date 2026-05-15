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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE module_progress MODIFY COLUMN current_step ENUM('P', 'E', 'D', 'U', 'L', 'I', 'S') DEFAULT 'P'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE module_progress MODIFY COLUMN current_step ENUM('P', 'E', 'D', 'U', 'L', 'I') DEFAULT 'P'");
    }
};
