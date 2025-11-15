@extends('layouts.app')

@section('title', 'تفاصيل المشروع - RAKEZ العقارية')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-info-circle text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">تفاصيل المشروع</h1>
        <p class="text-gray-600 mt-2">معلومات كاملة عن المشروع</p>
    </div>

    <!-- Project Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <!-- Project Information -->
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700">المعرف:</span>
                <span class="text-gray-900 font-mono">{{ $project->id }}</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700">اسم المشروع:</span>
                <span class="text-gray-900">{{ $project->name }}</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700">نوع المشروع:</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($project->type == 'apartment') bg-blue-100 text-blue-800
                    @elseif($project->type == 'floor') bg-green-100 text-green-800
                    @else bg-purple-100 text-purple-800 @endif">
                    {{ $project->formatted_type }}
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700">قيمة الخصم:</span>
                <span class="text-gray-900 font-medium">
                    {{ $project->formatted_value_discount }}
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700">نوع الخصم:</span>
                <span class="text-gray-900">
                    @if($project->type_discount)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($project->type_discount == 'percentage') bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $project->formatted_discount_type }}
                        </span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="font-medium text-gray-700">تاريخ الإنشاء:</span>
                <span class="text-gray-900">{{ $project->created_at->format('Y-m-d H:i') }}</span>
            </div>

            <div class="flex justify-between items-center py-3">
                <span class="font-medium text-gray-700">آخر تحديث:</span>
                <span class="text-gray-900">{{ $project->updated_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.projects.edit', $project) }}"
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-edit ml-2"></i>
                تعديل المشروع
            </a>
            <a href="{{ route('admin.projects.index') }}"
               class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع للقائمة
            </a>
        </div>
    </div>
</div>
@endsection
