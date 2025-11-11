<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\GameHelper;
use App\Models\UserProject;
class GameController extends Controller
{
    /**
     * Get 3 random projects for the game
     */
public function getRandomProjects(Request $request): JsonResponse
{
    try {
        // Check if user can play the game
        if (!GameHelper::canUserPlayGame()) {
            return response()->json([
                'success' => false,
                'message' => 'You have already played the game.',
                'has_played' => true
            ], 403);
        }

        // Get projects that have never been selected by any user
        $projects = GameHelper::getRandomProjects(3);
        
        // If no unselected projects available, use fallback
        if ($projects->isEmpty()) {
            $projects = GameHelper::getRandomProjectsWithFallback(3);
        }
        
        $formattedProjects = $projects->map(function ($project) {
            return GameHelper::formatProject($project);
        });

        return response()->json([
            'success' => true,
            'projects' => $formattedProjects,
            'has_played' => false,
            'stats' => GameHelper::getProjectStats() // Optional: include stats
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching projects: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Store user's selected project
     */
    public function selectProject(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id'
        ]);

        try {
            // Check if user can play the game
            if (!GameHelper::canUserPlayGame()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already played the game.'
                ], 403);
            }

            $success = GameHelper::storeUserProject($request->project_id);

            if ($success) {
                $selectedProject = GameHelper::getUserSelectedProject();

                return response()->json([
                    'success' => true,
                    'message' => 'Project selected successfully!',
                    'selected_project' => GameHelper::formatProject($selectedProject->project)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to select project. You may have already played.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error selecting project: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's game result
     */
    public function getGameResult(Request $request): JsonResponse
    {
        try {
            $selectedProject = GameHelper::getUserSelectedProject();

            if (!$selectedProject) {
                return response()->json([
                    'success' => false,
                    'message' => 'No project selected yet.',
                    'has_played' => false
                ]);
            }

            return response()->json([
                'success' => true,
                'has_played' => true,
                'selected_project' => GameHelper::formatProject($selectedProject->project),
                'selected_at' => $selectedProject->selected_at
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching game result: ' . $e->getMessage()
            ], 500);
        }
    }
}