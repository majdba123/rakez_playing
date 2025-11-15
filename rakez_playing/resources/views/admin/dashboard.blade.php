@extends('layouts.app')

@section('title', 'لوحة التحكم - RAKEZ العقارية')

@section('content')
<div class="glass-effect rounded-3xl shadow-2xl overflow-hidden p-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-crown text-white text-3xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-3">لوحة تحكم المدير</h2>
        <p class="text-xl text-gray-600">مرحباً, {{ Auth::user()->name }}! (مدير النظام)</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-12">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-users text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">إجمالي المستخدمين</h3>
            <p class="text-3xl font-bold">{{ $users->count() }}</p>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-user-shield text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">المديرين</h3>
            <p class="text-3xl font-bold">{{ $users->where('type', 1)->count() }}</p>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-building text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">المشاريع</h3>
            <p class="text-3xl font-bold">{{ $projectsCount }}</p>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white text-center">
            <i class="fas fa-trophy text-3xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">الفائزين</h3>
            <p class="text-3xl font-bold">{{ $winnersCount }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-200 mb-8">
        <h4 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-cogs ml-2 text-blue-600"></i>الإجراءات السريعة
        </h4>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="{{ route('admin.projects.index') }}"
               class="bg-white hover:bg-blue-50 border border-blue-200 rounded-xl p-4 text-center transition duration-200 transform hover:scale-105">
                <i class="fas fa-building text-blue-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">إدارة المشاريع</div>
                <div class="text-sm text-gray-600">عرض وتعديل المشاريع</div>
            </a>

            <a href="{{ route('admin.winners.index') }}"
               class="bg-white hover:bg-green-50 border border-green-200 rounded-xl p-4 text-center transition duration-200 transform hover:scale-105">
                <i class="fas fa-trophy text-green-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">الفائزين</div>
                <div class="text-sm text-gray-600">عرض وتصدير الفائزين</div>
            </a>

            <a href="{{ route('home') }}"
               class="bg-white hover:bg-purple-50 border border-purple-200 rounded-xl p-4 text-center transition duration-200 transform hover:scale-105">
                <i class="fas fa-home text-purple-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">الصفحة الرئيسية</div>
                <div class="text-sm text-gray-600">العودة للرئيسية</div>
            </a>
        </div>
    </div>

    <!-- Recent Winners Section -->
    <div class="bg-gradient-to-r from-gray-50 to-green-50 rounded-2xl p-6 border border-gray-200 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-xl font-bold text-gray-800 text-right">
                <i class="fas fa-trophy ml-2 text-green-600"></i>آخر الفائزين
            </h4>
            <a href="{{ route('admin.winners.index') }}"
               class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-xl transition duration-300 transform hover:scale-105 text-sm">
                <i class="fas fa-list ml-2"></i>عرض الكل
            </a>
        </div>

        @php
            $recentWinners = \App\Models\Winner::with('project')
                ->latest()
                ->take(5)
                ->get();
        @endphp

        @if($recentWinners->count() > 0)
        <div class="space-y-4">
            @foreach($recentWinners as $winner)
            <div class="bg-white rounded-xl p-4 border border-green-200 flex items-center justify-between">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trophy text-white text-lg"></i>
                    </div>
                    <div class="text-right">
                        <h5 class="font-semibold text-gray-800">{{ $winner->phone }}</h5>
                        <p class="text-sm text-gray-600">{{ $winner->project->name }}</p>
                    </div>
                </div>
                <div class="text-left">
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                        @if($winner->project_type === 'apartment') bg-blue-100 text-blue-800
                        @elseif($winner->project_type === 'floor') bg-green-100 text-green-800
                        @else bg-purple-100 text-purple-800 @endif">
                        {{ $winner->project_type === 'apartment' ? 'شقة' : ($winner->project_type === 'floor' ? 'دور' : 'وحدة') }}
                    </span>
                    <p class="text-xs text-gray-500 mt-1">{{ $winner->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <i class="fas fa-info-circle text-yellow-600 text-2xl mb-2"></i>
            <p class="text-yellow-700">لا توجد فوز مسجلة بعد</p>
        </div>
        @endif
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 text-right">المستخدمين المسجلين</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المعرف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الجوال</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النوع</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right dir-ltr">{{ $user->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($user->type == 1)
                                <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">مدير</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">مستخدم</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ $user->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
