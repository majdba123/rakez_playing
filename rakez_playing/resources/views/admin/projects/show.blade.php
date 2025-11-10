@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Project Details</h2>
    </div>

    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <span class="font-semibold text-gray-700">ID:</span>
            <span class="text-gray-900">{{ $project->id }}</span>
        </div>
        
        <div class="flex justify-between items-center border-b pb-3">
            <span class="font-semibold text-gray-700">Name:</span>
            <span class="text-gray-900">{{ $project->name }}</span>
        </div>
        
        <div class="flex justify-between items-center border-b pb-3">
            <span class="font-semibold text-gray-700">Type:</span>
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                @if($project->type == 'apartment') bg-blue-100 text-blue-800
                @elseif($project->type == 'floor') bg-green-100 text-green-800
                @else bg-purple-100 text-purple-800 @endif">
                {{ $project->formatted_type }}
            </span>
        </div>
        
        <div class="flex justify-between items-center border-b pb-3">
            <span class="font-semibold text-gray-700">Value Discount:</span>
            <span class="text-gray-900">{{ $project->value_discount ? number_format($project->value_discount, 2) : 'N/A' }}</span>
        </div>
        
        <div class="flex justify-between items-center border-b pb-3">
            <span class="font-semibold text-gray-700">Type Discount:</span>
            <span class="text-gray-900">{{ $project->type_discount ?? 'N/A' }}</span>
        </div>
        
        <div class="flex justify-between items-center border-b pb-3">
            <span class="font-semibold text-gray-700">Created At:</span>
            <span class="text-gray-900">{{ $project->created_at->format('M d, Y H:i') }}</span>
        </div>
        
        <div class="flex justify-between items-center">
            <span class="font-semibold text-gray-700">Updated At:</span>
            <span class="text-gray-900">{{ $project->updated_at->format('M d, Y H:i') }}</span>
        </div>
    </div>

    <div class="flex space-x-4 mt-6">
        <a href="{{ route('admin.projects.edit', $project) }}" 
           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold py-3 px-4 rounded-lg transition duration-200">
            <i class="fas fa-edit mr-2"></i>Edit Project
        </a>
        <a href="{{ route('admin.projects.index') }}" 
           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white text-center font-semibold py-3 px-4 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>
</div>
@endsection