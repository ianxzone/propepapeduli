<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'class_id', 'group_id', 'points'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function progress()
    {
        return $this->hasMany(ModuleProgress::class);
    }

    public function pointsLogs()
    {
        return $this->hasMany(PointsLog::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
