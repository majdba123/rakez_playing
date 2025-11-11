<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GameHelper;

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

    /**
     * Display the specified project.
     */
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
}