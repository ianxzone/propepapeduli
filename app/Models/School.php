<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'address', 'city'];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
