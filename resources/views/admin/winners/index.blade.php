@extends('layouts.app')

@section('title', 'الفائزين - RAKEZ العقارية')

@section('content')
<div class="glass-effect rounded-3xl shadow-2xl overflow-hidden p-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-trophy text-white text-3xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-3">إدارة الفائزين</h2>
        <p class="text-xl text-gray-600">عرض وتصدير بيانات الفائزين</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-12">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-trophy text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">إجمالي الفوز</h3>
            <p class="text-3xl font-bold">{{ $totalWinners }}</p>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-users text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">أرقام فريدة</h3>
            <p class="text-3xl font-bold">{{ $uniquePhones }}</p>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-building text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">إجمالي المشاريع</h3>
            <p class="text-3xl font-bold">{{ $totalProjects }}</p>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-calendar text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">فوز الأسبوع</h3>
            <p class="text-3xl font-bold">{{ $recentWinners }}</p>
        </div>
    </div>

    <!-- Winners by Type -->
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-200 mb-8">
        <h4 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-chart-pie ml-2 text-blue-600"></i>الفوز حسب النوع
        </h4>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-4 text-center border border-blue-200">
                <i class="fas fa-building text-blue-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">شقق سكنية</div>
                <div class="text-2xl font-bold text-blue-600">{{ $winnersByType['apartment'] ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center border border-green-200">
                <i class="fas fa-layer-group text-green-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">دور كامل</div>
                <div class="text-2xl font-bold text-green-600">{{ $winnersByType['floor'] ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center border border-purple-200">
                <i class="fas fa-home text-purple-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">وحدات سكنية</div>
                <div class="text-2xl font-bold text-purple-600">{{ $winnersByType['unit'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Export Button -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-3 rounded-2xl transition duration-300 transform hover:scale-105">
            <i class="fas fa-arrow-right ml-2"></i>العودة للوحة التحكم
        </a>

        <a href="{{ route('admin.winners.export') }}"
           class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-2xl transition duration-300 transform hover:scale-105">
            <i class="fas fa-download ml-2"></i>تصدير إلى CSV
        </a>
    </div>

    <!-- Winners Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 text-right">قائمة الفائزين</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الجوال</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المشروع</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نوع المشروع</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الخصم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الفوز</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($winners as $winner)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $loop->iteration + ($winners->currentPage() - 1) * $winners->perPage() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right dir-ltr">
                            {{ $winner->phone }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ $winner->name ?? 'غير مسجل' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ $winner->project->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($winner->project_type === 'apartment')
                                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">شقة سكنية</span>
                            @elseif($winner->project_type === 'floor')
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">دور كامل</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">وحدة سكنية</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ $winner->project->formatted_value_discount }}
                            <span class="text-xs text-gray-500">({{ $winner->project->formatted_discount_type }})</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                            {{ $winner->created_at->format('Y-m-d H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($winners->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $winners->links() }}
        </div>
        @endif
    </div>

    <!-- No Winners Message -->
    @if($winners->isEmpty())
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-8 text-center">
        <i class="fas fa-info-circle text-yellow-600 text-4xl mb-4"></i>
        <h3 class="text-xl font-bold text-yellow-800 mb-2">لا توجد فوز مسجلة بعد</h3>
        <p class="text-yellow-700">سيظهر الفائزون هنا عندما يبدأ المستخدمون بالفوز بالمشاريع.</p>
    </div>
    @endif
</div>
@endsection
