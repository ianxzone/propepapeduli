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
        Schema::table('teams', function (Blueprint $column) {
            $column->string('nip')->nullable()->after('position');
            $column->string('nidn')->nullable()->after('nip');
            $column->string('academic_rank')->nullable()->after('nidn');
            $column->text('education')->nullable()->after('bio');
            $column->string('expertise')->nullable()->after('education');
            $column->string('google_scholar')->nullable()->after('journal_links');
            $column->string('sinta_link')->nullable()->after('google_scholar');
            $column->string('scopus_link')->nullable()->after('sinta_link');
            $column->string('orcid_link')->nullable()->after('scopus_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $column) {
            $column->dropColumn([
                'nip', 'nidn', 'academic_rank', 'education', 
                'expertise', 'google_scholar', 'sinta_link', 
                'scopus_link', 'orcid_link'
            ]);
        });
    }
};
