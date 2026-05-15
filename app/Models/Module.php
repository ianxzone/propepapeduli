<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Module extends Model
{
    use LogsActivity;
    protected $fillable = ['title', 'description', 'thumbnail', 'is_active', 'badge_name', 'badge_icon', 'content'];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function progress()
    {
        return $this->hasMany(ModuleProgress::class);
    }
}
