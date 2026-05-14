<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsLog extends Model
{
    protected $table = 'points_log';
    protected $fillable = ['user_id', 'points', 'activity_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
