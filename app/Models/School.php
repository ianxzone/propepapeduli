<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class School extends Model
{
    use LogsActivity;
    protected $fillable = ['name', 'address', 'city'];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
