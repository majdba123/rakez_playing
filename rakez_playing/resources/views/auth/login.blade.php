@extends('layouts.app')

@section('title', 'تسجيل الدخول - RAKEZ العقارية')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-br from-blue-600 to-purple-700 p-8 text-white text-center">
                <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-shield text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2">لوحة المسؤول</h2>
                <p class="text-blue-100">سجل الدخول بحساب المسؤول</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-right">
                            <i class="fas fa-exclamation-circle ml-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Phone Field -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700 text-right">
                            <i class="fas fa-phone ml-2"></i>رقم الجوال
                        </label>
                        <input type="tel" id="phone" name="phone" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-right"
                               placeholder="أدخل رقم الجوال المسجل"
                               value="{{ old('phone') }}"
                               autofocus>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition duration-200 text-lg hover:from-blue-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-sign-in-alt ml-2"></i>دخول المسؤول
                    </button>

                    <!-- Info Message -->
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle ml-2"></i>
                            الدخول متاح فقط للمسؤولين المسجلين
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
