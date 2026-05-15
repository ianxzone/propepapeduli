<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    
    protected $fillable = ['school_id', 'name', 'class_code', 'teacher_name'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_id')->where('role', 'student');
    }
}
