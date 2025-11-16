@extends('layouts.app')

@section('title', 'الملف الشخصي - RAKEZ العقارية')

@section('content')
<div class="glass-effect rounded-3xl shadow-2xl overflow-hidden p-8">
    <div class="text-center mb-8">
        <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-user text-white text-3xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800">الملف الشخصي</h2>
        <p class="text-gray-600">إدارة معلوماتك الشخصية</p>
    </div>

    <!-- User Information -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 mb-8 border border-blue-100">
        <h3 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-info-circle ml-2 text-blue-600"></i>المعلومات الأساسية
        </h3>
        <div class="space-y-4">
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">الاسم الكامل:</span>
                    <span class="text-gray-900 font-semibold">{{ Auth::user()->name }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">رقم الجوال:</span>
                    <span class="text-gray-900 font-semibold">{{ Auth::user()->phone }}</span>
                </div>
            </div>
            @if(Auth::user()->email)
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">البريد الإلكتروني:</span>
                    <span class="text-gray-900 font-semibold">{{ Auth::user()->email }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Game Status -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200 mb-8">
        <h3 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-gamepad ml-2 text-green-600"></i>حالة اللعبة
        </h3>
        @if(Auth::user()->hasPlayedGame())
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <p class="text-green-700 text-lg">لقد شاركت في اللعبة بالفعل</p>
            </div>
        @else
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
                <p class="text-yellow-700 text-lg">لم تشارك في اللعبة بعد</p>
            </div>
        @endif
    </div>

    <!-- Back to Home -->
    <div class="text-center">
        <a href="{{ route('home') }}" class="btn-primary text-white px-8 py-3 rounded-xl transition duration-200 inline-block">
            <i class="fas fa-arrow-right ml-2"></i>العودة للرئيسية
        </a>
    </div>
</div>
@endsection