<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'name',
        'project_id', // This should be project_id, not projects_id
        'project_type'
    ];

    /**
     * Get the project that was won
     */
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id'); // Specify foreign key
    }

    /**
     * Check if phone has already won a specific project
     */
    public static function hasWonProject($phone, $projectId): bool
    {
        return static::where('phone', $phone)
                    ->where('project_id', $projectId)
                    ->exists();
    }

    /**
     * Get winners count for a project
     */
    public static function getWinnersCount($projectId): int
    {
        return static::where('project_id', $projectId)->count();
    }

    /**
     * Get all wins by a phone number
     */
    public static function getWinsByPhone($phone)
    {
        return static::with('project')
                    ->where('phone', $phone)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    /**
     * Check if phone has reached the maximum wins limit (3)
     */
    public static function hasReachedLimit($phone): bool
    {
        return static::where('phone', $phone)->count() >= 3;
    }

    /**
     * Get remaining wins for a phone number
     */
    public static function getRemainingWins($phone): int
    {
        $currentWins = static::where('phone', $phone)->count();
        return max(0, 3 - $currentWins);
    }
}
