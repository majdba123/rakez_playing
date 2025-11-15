@extends('layouts.app')

@section('title', 'إدارة المشاريع - RAKEZ العقارية')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">إدارة المشاريع</h1>
            <p class="text-gray-600 mt-2">عرض وإدارة جميع المشاريع في النظام</p>
        </div>
        <a href="{{ route('admin.projects.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
            <i class="fas fa-plus ml-2"></i>
            إضافة مشروع جديد
        </a>
    </div>

    <!-- Projects Count -->
    <div class="mb-4 text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
        عرض {{ $projects->firstItem() }} إلى {{ $projects->lastItem() }} من أصل {{ $projects->total() }} مشروع
    </div>

    <!-- Projects Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المعرف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النوع</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">قيمة الخصم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نوع الخصم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $project->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">{{ $project->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($project->type == 'apartment') bg-blue-100 text-blue-800
                                @elseif($project->type == 'floor') bg-green-100 text-green-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ $project->formatted_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ $project->formatted_value_discount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            @if($project->type_discount)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($project->type_discount == 'percentage') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $project->formatted_discount_type }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ $project->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('admin.projects.edit', $project) }}"
                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.projects.show', $project) }}"
                                   class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="deleteProject({{ $project->id }})"
                                        class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg mb-2">لا توجد مشاريع</p>
                                <a href="{{ route('admin.projects.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                    أنشئ مشروعك الأول
                                </a>
                            </div>
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
                السابق
            </span>
            @else
            <a href="{{ $projects->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                السابق
            </a>
            @endif

            @if($projects->hasMorePages())
            <a href="{{ $projects->nextPageUrl() }}" class="relative mr-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                التالي
            </a>
            @else
            <span class="relative mr-3 inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">
                التالي
            </span>
            @endif
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    عرض
                    <span class="font-medium">{{ $projects->firstItem() }}</span>
                    إلى
                    <span class="font-medium">{{ $projects->lastItem() }}</span>
                    من أصل
                    <span class="font-medium">{{ $projects->total() }}</span>
                    نتيجة
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Previous Page Link -->
                    @if($projects->onFirstPage())
                    <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-not-allowed">
                        <span class="sr-only">السابق</span>
                        <i class="fas fa-chevron-right h-4 w-4"></i>
                    </span>
                    @else
                    <a href="{{ $projects->previousPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <span class="sr-only">السابق</span>
                        <i class="fas fa-chevron-right h-4 w-4"></i>
                    </a>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                        @if($page == $projects->currentPage())
                        <span class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                            {{ $page }}
                        </span>
                        @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if($projects->hasMorePages())
                    <a href="{{ $projects->nextPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <span class="sr-only">التالي</span>
                        <i class="fas fa-chevron-left h-4 w-4"></i>
                    </a>
                    @else
                    <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-not-allowed">
                        <span class="sr-only">التالي</span>
                        <i class="fas fa-chevron-left h-4 w-4"></i>
                    </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
    @endif

    <!-- Back to Dashboard -->
    <div class="mt-8 text-center">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center justify-center">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة إلى لوحة التحكم
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
    if (confirm('هل أنت متأكد من رغبتك في حذف هذا المشروع؟')) {
        const form = document.getElementById('deleteProjectForm');
        form.action = `/admin/projects/${projectId}`;
        form.submit();
    }
}
</script>
@endsection
