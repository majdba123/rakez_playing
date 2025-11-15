<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->type == 1;
    }

    public static function phoneExists($phone): bool
    {
        return static::where('phone', $phone)->exists();
    }

    public function userProjects()
    {
        return $this->hasMany(UserProject::class);
    }

    public function selectedProjects()
    {
        return $this->belongsToMany(Projects::class, 'user_projects')
                    ->withTimestamps()
                    ->withPivot('selected_at');
    }

    public function hasPlayedGame()
    {
        return $this->userProjects()->exists();
    }
}
