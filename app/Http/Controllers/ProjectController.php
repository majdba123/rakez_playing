<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GameHelper;
use Illuminate\Support\Facades\Storage;
use App\Models\ProjectUpload;

class ProjectController extends Controller
{
    /**
     * Check if user is admin
     */
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->type != 1) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }
    }

    /**
     * Display a listing of the projects with pagination.
     */
    public function index()
    {
        $this->checkAdmin();
        $projects = Projects::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $this->checkAdmin();
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255|unique:projects,name',
            'type' => 'required|in:apartment,floor,unit',
            'value_discount' => 'required|numeric|min:0',
            'type_discount' => 'required|in:percentage,fixed',
        ], [
            'name.required' => 'Project name is required.',
            'name.unique' => 'A project with this name already exists.',
            'type_discount.required' => 'Please select discount type.',
            'value_discount.required' => 'Discount value is required.',
        ]);

        // Additional validation for percentage (0-100)
        if ($request->type_discount === 'percentage' && $request->value_discount > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Percentage discount cannot exceed 100%.'
            ], 422);
        }

        try {
            Projects::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Project created successfully!',
                'redirect' => route('admin.projects.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating project: ' . $e->getMessage()
            ], 500);
        }
    }




public function uploadProjects(Request $request): JsonResponse
{
    $this->checkAdmin();

    $request->validate([
        'projects_file' => 'required|file|mimes:csv,txt|max:10240'
    ], [
        'projects_file.required' => 'الرجاء اختيار ملف CSV',
        'projects_file.mimes' => 'الملف يجب أن يكون بصيغة CSV',
        'projects_file.max' => 'حجم الملف يجب ألا يتجاوز 10MB'
    ]);

    try {
        // Get the uploaded file
        $file = $request->file('projects_file');

        // Debug: Check file info
        \Log::info('File uploaded:', [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType()
        ]);

        // Delete old projects file if exists
        $staticFileName = 'projects.csv';
        $filePath = 'projects/' . $staticFileName;

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Store new file with static name
        $file->storeAs('projects', $staticFileName, 'public');

        // Process the CSV file
        $fullPath = Storage::disk('public')->path('projects/' . $staticFileName);

        \Log::info('File stored at: ' . $fullPath);

        // Check if file exists and is readable
        if (!file_exists($fullPath)) {
            throw new \Exception("الملف غير موجود في المسار: " . $fullPath);
        }

        // Import new projects
        $importedCount = 0;
        $skippedCount = 0;
        $rowNumber = 0;

        $csvFile = fopen($fullPath, 'r');

        if (!$csvFile) {
            throw new \Exception("لا يمكن فتح ملف CSV.");
        }

        // Read and log the header
        $header = fgetcsv($csvFile);
        \Log::info('CSV Header:', $header);

        // Process each row
        while (($row = fgetcsv($csvFile)) !== false) {
            $rowNumber++;

            \Log::info("Processing row {$rowNumber}:", $row);

            // Skip empty rows
            if (empty($row) || (count($row) === 1 && empty(trim($row[0])))) {
                \Log::info("Skipped empty row {$rowNumber}");
                $skippedCount++;
                continue;
            }

            try {
                // Clean the row data
                $cleanedRow = array_map('trim', $row);

                // Map CSV columns to project fields
                $projectData = [
                    'name' => $cleanedRow[0] ?? '',
                    'type' => $cleanedRow[1] ?? 'apartment',
                    'value_discount' => floatval($cleanedRow[2] ?? 0),
                    'type_discount' => $cleanedRow[3] ?? 'fixed',
                ];

                \Log::info("Row {$rowNumber} data:", $projectData);

                // Validate required fields
                if (empty($projectData['name'])) {
                    \Log::warning("Skipped row {$rowNumber}: Empty project name");
                    $skippedCount++;
                    continue;
                }

                // Validate and fix type
                $validTypes = ['apartment', 'floor', 'unit'];
                if (!in_array($projectData['type'], $validTypes)) {
                    \Log::warning("Invalid type '{$projectData['type']}' in row {$rowNumber}, using 'apartment'");
                    $projectData['type'] = 'apartment';
                }

                // Validate and fix type_discount
                $validDiscountTypes = ['percentage', 'fixed'];
                if (!in_array($projectData['type_discount'], $validDiscountTypes)) {
                    \Log::warning("Invalid discount type '{$projectData['type_discount']}' in row {$rowNumber}, using 'fixed'");
                    $projectData['type_discount'] = 'fixed';
                }

                // Validate value_discount for percentage
                if ($projectData['type_discount'] === 'percentage' && $projectData['value_discount'] > 100) {
                    \Log::warning("Percentage discount too high in row {$rowNumber}, setting to 100");
                    $projectData['value_discount'] = 100;
                }

                // Ensure value_discount is not negative
                if ($projectData['value_discount'] < 0) {
                    \Log::warning("Negative discount in row {$rowNumber}, setting to 0");
                    $projectData['value_discount'] = 0;
                }

                // Create project
                Projects::create($projectData);
                $importedCount++;
                \Log::info("Successfully imported row {$rowNumber}: {$projectData['name']}");

            } catch (\Exception $e) {
                $skippedCount++;
                \Log::error("Error importing row {$rowNumber}: " . $e->getMessage());
            }
        }

        fclose($csvFile);

        // Record the upload
        ProjectUpload::create([
            'file_name' => $staticFileName,
            'projects_count' => $importedCount
        ]);

        \Log::info("Import completed: {$importedCount} imported, {$skippedCount} skipped");

        return response()->json([
            'success' => true,
            'message' => "تم تحديث المشاريع بنجاح! تم استيراد {$importedCount} مشروع جديد.",
            'redirect' => route('admin.projects.index')
        ]);

    } catch (\Exception $e) {
        \Log::error('Upload projects error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'خطأ في تحديث المشاريع: ' . $e->getMessage()
        ], 500);
    }
}







    public function show(Projects $project)
    {
        $this->checkAdmin();
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Projects $project)
    {
        $this->checkAdmin();
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Projects $project): JsonResponse
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255|unique:projects,name,' . $project->id,
            'type' => 'required|in:apartment,floor,unit',
            'value_discount' => 'required|numeric|min:0',
            'type_discount' => 'required|in:percentage,fixed',
        ], [
            'name.required' => 'Project name is required.',
            'name.unique' => 'A project with this name already exists.',
            'type_discount.required' => 'Please select discount type.',
            'value_discount.required' => 'Discount value is required.',
        ]);

        // Additional validation for percentage (0-100)
        if ($request->type_discount === 'percentage' && $request->value_discount > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Percentage discount cannot exceed 100%.'
            ], 422);
        }

        try {
            $project->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully!',
                'redirect' => route('admin.projects.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating project: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Projects $project): JsonResponse
    {
        $this->checkAdmin();

        try {
            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting project: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of winners with statistics.
     */
    public function winners()
    {
        $this->checkAdmin();

        // Get all winners with project information
        $winners = Winner::with('project')
            ->latest()
            ->paginate(20);

        // Statistics
        $totalWinners = Winner::count();
        $uniquePhones = Winner::distinct('phone')->count('phone');
        $totalProjects = Projects::count();

        // Winners by project type
        $winnersByType = Winner::selectRaw('project_type, COUNT(*) as count')
            ->groupBy('project_type')
            ->get()
            ->pluck('count', 'project_type');

        // Recent winners (last 7 days)
        $recentWinners = Winner::where('created_at', '>=', now()->subDays(7))->count();

        return view('admin.winners.index', compact(
            'winners',
            'totalWinners',
            'uniquePhones',
            'totalProjects',
            'winnersByType',
            'recentWinners'
        ));
    }

    /**
     * Export winners to CSV
     */
    public function exportWinners()
    {
        $this->checkAdmin();

        $winners = Winner::with('project')->latest()->get();

        $fileName = 'winners_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($winners) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

            // Add headers
            fputcsv($file, [
                'رقم الجوال',
                'الاسم',
                'المشروع',
                'نوع المشروع',
                'الخصم',
                'نوع الخصم',
                'تاريخ الفوز'
            ]);

            // Add data
            foreach ($winners as $winner) {
                fputcsv($file, [
                    $winner->phone,
                    $winner->name ?? 'غير مسجل',
                    $winner->project->name,
                    $winner->project_type,
                    $winner->project->value_discount,
                    $winner->project->type_discount,
                    $winner->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
