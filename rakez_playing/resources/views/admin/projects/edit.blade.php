@extends('layouts.app')

@section('title', 'تعديل المشروع - RAKEZ العقارية')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-edit text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">تعديل المشروع</h1>
        <p class="text-gray-600 mt-2">قم بتحديث بيانات المشروع</p>
        <div class="mt-2 text-sm text-gray-500">
            رقم المشروع: {{ $project->id }}
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form id="projectForm" action="{{ route('admin.projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        اسم المشروع
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $project->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           placeholder="أدخل اسم المشروع">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type Field -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        نوع المشروع
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="type" name="type" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">اختر نوع المشروع</option>
                        <option value="apartment" {{ old('type', $project->type) == 'apartment' ? 'selected' : '' }}>شقة</option>
                        <option value="floor" {{ old('type', $project->type) == 'floor' ? 'selected' : '' }}>دور</option>
                        <option value="unit" {{ old('type', $project->type) == 'unit' ? 'selected' : '' }}>وحدة</option>
                    </select>
                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type Discount Field -->
                <div>
                    <label for="type_discount" class="block text-sm font-medium text-gray-700 mb-2">
                        نوع الخصم
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="type_discount" name="type_discount" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">اختر نوع الخصم</option>
                        <option value="percentage" {{ old('type_discount', $project->type_discount) == 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>
                        <option value="fixed" {{ old('type_discount', $project->type_discount) == 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                    </select>
                    @error('type_discount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Value Discount Field -->
                <div>
                    <label for="value_discount" class="block text-sm font-medium text-gray-700 mb-2">
                        قيمة الخصم
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="value_discount" name="value_discount" step="0.01" min="0" required
                           value="{{ old('value_discount', $project->value_discount) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           placeholder="أدخل قيمة الخصم">
                    <p id="discountHelp" class="mt-2 text-sm text-gray-500">
                        @if(old('type_discount', $project->type_discount) == 'percentage')
                            أدخل قيمة النسبة المئوية من 0% إلى 100%
                        @else
                            أدخل المبلغ الثابت للخصم
                        @endif
                    </p>
                    @error('value_discount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Information -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-3">معلومات المشروع</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="text-gray-600 text-right">تاريخ الإنشاء:</div>
                        <div class="text-gray-900 text-right">{{ $project->created_at->format('Y-m-d H:i') }}</div>

                        <div class="text-gray-600 text-right">آخر تحديث:</div>
                        <div class="text-gray-900 text-right">{{ $project->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" id="submitBtn"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التعديلات
                    </button>
                    <a href="{{ route('admin.projects.index') }}"
                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-right ml-2"></i>
                        رجوع
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Dynamic help text for discount type
document.getElementById('type_discount').addEventListener('change', function() {
    const helpText = document.getElementById('discountHelp');
    const valueDiscount = document.getElementById('value_discount');

    if (this.value === 'percentage') {
        helpText.textContent = 'أدخل قيمة النسبة المئوية من 0% إلى 100%';
        helpText.className = 'mt-2 text-sm text-green-600';
        valueDiscount.max = 100;
        valueDiscount.placeholder = 'أدخل النسبة المئوية';
    } else {
        helpText.textContent = 'أدخل المبلغ الثابت للخصم';
        helpText.className = 'mt-2 text-sm text-blue-600';
        valueDiscount.removeAttribute('max');
        valueDiscount.placeholder = 'أدخل المبلغ الثابت';
    }
});

// Form submission with AJAX
document.getElementById('projectForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i>جاري التحديث...';

    try {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showNotification('success', data.message);

            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            showNotification('error', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'حدث خطأ ما. يرجى المحاولة مرة أخرى.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.className = `fixed top-6 left-6 p-4 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} ml-2"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Initialize help text on page load
document.addEventListener('DOMContentLoaded', function() {
    const typeDiscount = document.getElementById('type_discount');
    if (typeDiscount.value) {
        typeDiscount.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
