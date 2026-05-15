<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_groups', function (Blueprint $blade) {
            $blade->id();
            $blade->string('name');
            $blade->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $blade->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $blade->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->constrained('student_groups')->onDelete('set null');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->constrained('student_groups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });

        Schema::dropIfExists('student_groups');
    }
};
