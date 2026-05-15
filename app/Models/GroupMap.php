<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMap extends Model
{
    protected $fillable = ['group_id', 'module_id', 'content'];

    protected $casts = [
        'content' => 'array',
    ];

    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
