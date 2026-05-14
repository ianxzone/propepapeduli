<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Seed default settings
        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'ProPePa PEDULI LMS', 'group' => 'branding'],
            ['key' => 'site_description', 'value' => 'Platform Pembelajaran Profil Pelajar Pancasila', 'group' => 'branding'],
            ['key' => 'timezone', 'value' => 'Asia/Jakarta', 'group' => 'localization'],
            ['key' => 'locale', 'value' => 'id', 'group' => 'localization'],
            ['key' => 'contact_email', 'value' => 'admin@propepapeduli.id', 'group' => 'general'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
