<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['user_id', 'module_id', 'step', 'content', 'emotion_emoji', 'is_private', 'teacher_feedback', 'teacher_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
