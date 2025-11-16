<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Projects;
use App\Models\Winner;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Get random project by type - prioritize projects with no winners first
     */
    public function getRandomProjectByType($type): JsonResponse
    {
        try {
            // Validate project type
            $validTypes = ['apartment', 'floor', 'unit'];
            if (!in_array($type, $validTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'نوع المشروع غير صحيح.'
                ], 400);
            }

            // Method 1: Use raw SQL to avoid relationship issues
            $project = Projects::where('type', $type)
                ->whereNotIn('id', function($query) {
                    $query->select('project_id')
                          ->from('winners');
                })
                ->inRandomOrder()
                ->first();

            // If no projects without winners, get any random project
            if (!$project) {
                $project = Projects::where('type', $type)
                    ->inRandomOrder()
                    ->first();
            }

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا توجد مشاريع متاحة من هذا النوع حالياً.'
                ], 404);
            }

            // Manually calculate winners count
            $winnersCount = Winner::where('project_id', $project->id)->count();

            return response()->json([
                'success' => true,
                'project' => $this->formatProject($project, $winnersCount),
                'project_type' => $type,
                'has_winners' => $winnersCount > 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في جلب المشروع: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Claim project with phone number (public API)
     */
    public function claimProject(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'phone' => 'required|string|max:20',
            'name' => 'nullable|string|max:255'
        ]);

        try {
            $project = Projects::find($request->project_id);

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'المشروع غير موجود.'
                ], 404);
            }

            // Check if phone has reached the maximum limit (3 wins)
            if (Winner::hasReachedLimit($request->phone)) {
                $currentWins = Winner::where('phone', $request->phone)->count();
                return response()->json([
                    'success' => false,
                    'message' => 'لقد وصلت إلى الحد الأقصى للفوز (3 مشاريع). لا يمكنك الفوز بالمزيد.'
                ], 400);
            }

            // Check if this phone has already won THIS SPECIFIC project
            if (Winner::hasWonProject($request->phone, $request->project_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'لقد فزت بهذا المشروع مسبقاً.'
                ], 400);
            }

            // Create winner record
            $winner = Winner::create([
                'phone' => $request->phone,
                'name' => $request->name,
                'project_id' => $request->project_id,
                'project_type' => $project->type
            ]);

            $remainingWins = Winner::getRemainingWins($request->phone);
            $winnersCount = Winner::where('project_id', $project->id)->count();

            return response()->json([
                'success' => true,
                'message' => 'مبروك! لقد فزت بالمشروع بنجاح.' . ($remainingWins > 0 ? ' متبقي لك ' . $remainingWins . ' فرص للفوز.' : ' لقد استخدمت جميع فرصك للفوز.'),
                'winner' => [
                    'phone' => $winner->phone,
                    'name' => $winner->name,
                    'project' => $this->formatProject($project, $winnersCount),
                    'won_at' => $winner->created_at->format('Y-m-d H:i:s'),
                    'is_first_winner' => $winnersCount == 1,
                    'remaining_wins' => $remainingWins,
                    'total_wins' => Winner::where('phone', $request->phone)->count()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في تسجيل الفوز: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's wins by phone number
     */
    public function getUserWins(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|max:20'
        ]);

        try {
            $wins = Winner::getWinsByPhone($request->phone);
            $totalWins = $wins->count();
            $remainingWins = Winner::getRemainingWins($request->phone);

            $formattedWins = $wins->map(function($win) {
                $winnersCount = Winner::where('project_id', $win->project_id)->count();
                return [
                    'project' => $this->formatProject($win->project, $winnersCount),
                    'won_at' => $win->created_at->format('Y-m-d H:i:s'),
                    'name' => $win->name
                ];
            });

            return response()->json([
                'success' => true,
                'wins' => $formattedWins,
                'total_wins' => $totalWins,
                'remaining_wins' => $remainingWins,
                'has_reached_limit' => $totalWins >= 3
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في جلب الفوز: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format project for API response
     */
    private function formatProject($project, $winnersCount = null)
    {
        if ($winnersCount === null) {
            $winnersCount = Winner::where('project_id', $project->id)->count();
        }

        return [
            'id' => $project->id,
            'name' => $project->name,
            'type' => $project->type,
            'formatted_type' => $project->formatted_type,
            'value_discount' => $project->value_discount,
            'type_discount' => $project->type_discount,
            'formatted_discount_type' => $project->formatted_discount_type,
            'formatted_value_discount' => $project->formatted_value_discount,
            'winners_count' => $winnersCount,
            'is_new' => $winnersCount == 0
        ];
    }
}
