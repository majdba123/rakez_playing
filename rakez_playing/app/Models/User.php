<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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


    public static function phoneExists($phone): bool
    {
        return static::where('phone', $phone)->exists();
    }



    public function userProjects()
    {
        return $this->hasMany(UserProject::class);
    }

    /**
     * Get the projects selected by the user
     */
    public function selectedProjects()
    {
        return $this->belongsToMany(Projects::class, 'user_projects')
                    ->withTimestamps()
                    ->withPivot('selected_at');
    }

    /**
     * Check if user has already played the game
     */
    public function hasPlayedGame()
    {
        return $this->userProjects()->exists();
    }
}
