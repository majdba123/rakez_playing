@extends('layouts.app')

@section('title', 'تسجيل جديد - RAKEZ العقارية')

@section('content')
<div class="glass-effect rounded-3xl shadow-2xl overflow-hidden">
    <div class="md:flex">
        <!-- Left Side - Branding -->
        <div class="md:w-2/5 bg-gradient-to-br from-blue-600 to-purple-700 p-8 text-white">
            <div class="text-center">
                <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-building text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-4">RAKEZ العقارية</h2>
                <p class="text-blue-100 mb-6">انضم إلى عائلتنا وابدأ رحلتك العقارية</p>
                
                <div class="space-y-4 text-right">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-check-circle text-green-300"></i>
                        <span>أفضل المشاريع العقارية</span>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-check-circle text-green-300"></i>
                        <span>عروض حصرية</span>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-check-circle text-green-300"></i>
                        <span>دعم متكامل</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="md:w-3/5 p-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800">إنشاء حساب جديد</h3>
                <p class="text-gray-600">املأ البيانات للتسجيل في النظام</p>
            </div>

            <form id="registerForm" class="space-y-6">
                @csrf
                
                <!-- Name Field -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 text-right">
                        <i class="fas fa-user ml-2"></i>الاسم الكامل
                    </label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-right"
                           placeholder="أدخل اسمك الكامل">
                </div>

                <!-- Phone Field -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700 text-right">
                        <i class="fas fa-phone ml-2"></i>رقم الجوال
                    </label>
                    <input type="tel" id="phone" name="phone" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-right"
                           placeholder="05XXXXXXXX">
                </div>


                <!-- Submit Button -->
                <button type="submit" id="submitBtn"
                        class="w-full btn-primary text-white font-semibold py-4 px-6 rounded-xl transition duration-200 text-lg">
                    <i class="fas fa-user-plus ml-2"></i>تسجيل حساب جديد
                                </button>

                <!-- Loading State -->
                <div id="loading" class="hidden text-center">
                    <div class="flex items-center justify-center space-x-2 space-x-reverse text-blue-600">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>  جاري  ...</span>
                    </div>
                </div>
            </form>

            <!-- Success Modal -->
            <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-2xl p-8 max-w-sm mx-4 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">تم بنجاح!</h3>
                    <p class="text-gray-600 mb-6" id="successMessage">تم إنشاء الحساب بنجاح</p>
                    <div class="flex items-center justify-center text-sm text-gray-500 mb-6">
                        <i class="fas fa-spinner fa-spin ml-2"></i>
                        <span>جاري التوجيه...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const loading = document.getElementById('loading');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.classList.add('hidden');
    loading.classList.remove('hidden');

    try {
        const formData = new FormData(this);
        const response = await fetch('/users', {
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
            // Show success modal
            const successModal = document.getElementById('successModal');
            successModal.classList.remove('hidden');
            
            // Redirect after delay
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 2000);
        } else {
            alert('خطأ: ' + data.message);
            submitBtn.classList.remove('hidden');
            loading.classList.add('hidden');
        }
    } catch (error) {
        alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
        submitBtn.classList.remove('hidden');
        loading.classList.add('hidden');
    }
});
</script>
@endsection