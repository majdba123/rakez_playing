@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Projects Management</h2>
            <p class="text-gray-600 mt-2">Manage your projects here</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Add New Project
        </a>
    </div>

    <!-- Projects Count -->
    <div class="mb-4 text-sm text-gray-600">
        Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} projects
    </div>

    <!-- Projects Table -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $project->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($project->type == 'apartment') bg-blue-100 text-blue-800
                                @elseif($project->type == 'floor') bg-green-100 text-green-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ $project->formatted_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $project->formatted_value_discount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($project->type_discount)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($project->type_discount == 'percentage') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $project->formatted_discount_type }}
                                </span>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.projects.show', $project) }}" 
                                   class="text-green-600 hover:text-green-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="deleteProject({{ $project->id }})" 
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No projects found. <a href="{{ route('admin.projects.create') }}" class="text-blue-600 hover:text-blue-700">Create one!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg">
        <div class="flex flex-1 justify-between sm:hidden">
            @if($projects->onFirstPage())
            <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">
                Previous
            </span>
            @else
            <a href="{{ $projects->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Previous
            </a>
            @endif

            @if($projects->hasMorePages())
            <a href="{{ $projects->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Next
            </a>
            @else
            <span class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">
                Next
            </span>
            @endif
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $projects->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $projects->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $projects->total() }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Previous Page Link -->
                    @if($projects->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-not-allowed">
                        <span class="sr-only">Previous</span>
                        <i class="fas fa-chevron-left h-4 w-4"></i>
                    </span>
                    @else
                    <a href="{{ $projects->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <i class="fas fa-chevron-left h-4 w-4"></i>
                    </a>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                        @if($page == $projects->currentPage())
                        <span class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            {{ $page }}
                        </span>
                        @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            {{ $page }}
                        </a>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if($projects->hasMorePages())
                    <a href="{{ $projects->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <i class="fas fa-chevron-right h-4 w-4"></i>
                    </a>
                    @else
                    <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-not-allowed">
                        <span class="sr-only">Next</span>
                        <i class="fas fa-chevron-right h-4 w-4"></i>
                    </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
    @endif

    <!-- Back to Dashboard -->
    <div class="mt-6 text-center">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteProjectForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteProject(projectId) {
    if (confirm('Are you sure you want to delete this project?')) {
        const form = document.getElementById('deleteProjectForm');
        form.action = `/admin/projects/${projectId}`;
        form.submit();
    }
}
</script>
@endsection