<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Team extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name',
        'position',
        'nip',
        'nidn',
        'academic_rank',
        'description',
        'bio',
        'education',
        'expertise',
        'journal_links',
        'google_scholar',
        'sinta_link',
        'scopus_link',
        'orcid_link',
        'image',
        'order',
        'is_active'
    ];

    protected $casts = [
        'journal_links' => 'array',
        'education' => 'array',
        'is_active' => 'boolean'
    ];
}
