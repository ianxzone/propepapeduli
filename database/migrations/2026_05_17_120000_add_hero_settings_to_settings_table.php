<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')->insert([
            ['key' => 'hero_badge', 'value' => 'LMS Pembelajaran Berbasis Proyek', 'group' => 'hero'],
            ['key' => 'hero_title', 'value' => 'Wujudkan <span class="text-primary-fixed-dim">Profil Pelajar</span> Pancasila.', 'group' => 'hero'],
            ['key' => 'hero_description', 'value' => 'Platform LMS modern yang dirancang khusus untuk mendukung Siklus PEDULI dalam pembelajaran berbasis proyek yang interaktif dan menyenangkan.', 'group' => 'hero'],
            ['key' => 'hero_cta_text', 'value' => 'Mulai Belajar Sekarang', 'group' => 'hero'],
            ['key' => 'hero_students_count', 'value' => '+100 Siswa Terdaftar', 'group' => 'hero'],
            ['key' => 'hero_show_leaderboard', 'value' => '1', 'group' => 'hero'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'hero_badge',
            'hero_title',
            'hero_description',
            'hero_cta_text',
            'hero_students_count',
            'hero_show_leaderboard'
        ])->delete();
    }
};
