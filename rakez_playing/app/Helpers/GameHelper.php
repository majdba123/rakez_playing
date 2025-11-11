<?php

namespace App\Helpers;

use App\Models\Projects;
use App\Models\UserProject;
use Illuminate\Support\Facades\Auth;

class GameHelper
{
    /**
     * Get 3 random projects that have never been selected by any user
     */
    public static function getRandomProjects($count = 3)
    {
        // Get projects that have never been selected by any user
        return Projects::whereNotIn('id', function($query) {
                $query->select('project_id')
                      ->from('user_projects');
            })
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }

    /**
     * Alternative method: Get projects not selected by current user
     * (if you want users to see different projects even if others selected them)
     */
    public static function getRandomProjectsNotSelectedByUser($count = 3)
    {
        if (!Auth::check()) {
            return collect();
        }

        $userId = Auth::id();

        // Get projects that current user hasn't selected
        return Projects::whereNotIn('id', function($query) use ($userId) {
                $query->select('project_id')
                      ->from('user_projects')
                      ->where('user_id', $userId);
            })
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }

    /**
     * Get projects with fallback - if not enough unselected projects, get any random ones
     */
    public static function getRandomProjectsWithFallback($count = 3)
    {
        // First try to get projects never selected by any user
        $unselectedProjects = Projects::whereNotIn('id', function($query) {
                $query->select('project_id')
                      ->from('user_projects');
            })
            ->inRandomOrder()
            ->limit($count)
            ->get();

        // If we don't have enough unselected projects, get random ones to fill the count
        if ($unselectedProjects->count() < $count) {
            $neededCount = $count - $unselectedProjects->count();
            $randomProjects = Projects::inRandomOrder()
                ->limit($neededCount)
                ->get();
            
            return $unselectedProjects->merge($randomProjects);
        }

        return $unselectedProjects;
    }

    /**
     * Check if user can play the game (hasn't played before)
     */
    public static function canUserPlayGame()
    {
        return Auth::check() && !Auth::user()->hasPlayedGame();
    }

    /**
     * Store user's selected project
     */
    public static function storeUserProject($projectId)
    {
        if (!Auth::check()) {
            return false;
        }

        $userId = Auth::id();

        // Check if user already selected a project
        if (UserProject::where('user_id', $userId)->exists()) {
            return false;
        }

        // Check if project exists
        $project = Projects::find($projectId);
        if (!$project) {
            return false;
        }

        try {
            UserProject::create([
                'user_id' => $userId,
                'project_id' => $projectId,
                'selected_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get user's selected project with details
     */
    public static function getUserSelectedProject()
    {
        if (!Auth::check()) {
            return null;
        }

        return UserProject::with('project')
            ->where('user_id', Auth::id())
            ->first();
    }

    /**
     * Format project for API response
     */
    public static function formatProject($project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'type' => $project->type,
            'formatted_type' => $project->formatted_type,
            'value_discount' => $project->value_discount,
            'type_discount' => $project->type_discount,
            'formatted_discount_type' => $project->formatted_discount_type,
            'formatted_value_discount' => $project->formatted_value_discount,
        ];
    }

    /**
     * Check if there are enough projects for the game
     */
    public static function hasEnoughProjects($count = 3)
    {
        $availableProjects = Projects::whereNotIn('id', function($query) {
                $query->select('project_id')
                      ->from('user_projects');
            })->count();

        return $availableProjects >= $count;
    }

    /**
     * Get statistics about project selection
     */
    public static function getProjectStats()
    {
        $totalProjects = Projects::count();
        $selectedProjects = UserProject::distinct('project_id')->count('project_id');
        $unselectedProjects = $totalProjects - $selectedProjects;

        return [
            'total_projects' => $totalProjects,
            'selected_projects' => $selectedProjects,
            'unselected_projects' => $unselectedProjects,
        ];
    }
}