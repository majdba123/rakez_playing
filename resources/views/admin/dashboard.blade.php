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

    <!-- Projects CSV Upload Section -->
    <div class="bg-gradient-to-r from-gray-50 to-purple-50 rounded-2xl p-6 border border-gray-200 mb-8">
        <h4 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-file-csv ml-2 text-green-600"></i>رفع ملف المشاريع
        </h4>

        <div class="bg-white rounded-xl p-6 border border-green-200 max-w-2xl mx-auto">
            <div class="text-center mb-6">
                <i class="fas fa-cloud-upload-alt text-green-500 text-4xl mb-4"></i>
                <h5 class="font-semibold text-gray-800 text-lg">رفع ملف المشاريع الجديد</h5>
                <p class="text-sm text-gray-600 mt-2">سيتم استبدال جميع المشاريع الحالية بالبيانات الجديدة</p>
            </div>

            <form id="projectsUploadForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3 text-right">ملف CSV للمشاريع</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-green-500 transition duration-300">
                        <input type="file" name="projects_file" id="projects_file"
                               class="hidden" accept=".csv" required>
                        <div id="fileUploadArea" class="cursor-pointer">
                            <i class="fas fa-file-csv text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-600">انقر لرفع ملف CSV</p>
                            <p class="text-xs text-gray-500 mt-2">سيتم حفظ الملف باسم: projects.csv</p>
                        </div>
                        <div id="fileName" class="hidden mt-3">
                            <i class="fas fa-check text-green-500 ml-2"></i>
                            <span class="text-sm font-medium text-gray-800" id="selectedFileName"></span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-right">يدعم صيغة: .csv فقط</p>
                </div>

                <!-- CSV Format Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 ml-3"></i>
                        <div class="text-right">
                            <p class="text-blue-800 font-semibold">تنسيق ملف CSV المطلوب:</p>
                            <p class="text-blue-700 text-sm mt-1">name,type,value_discount,type_discount</p>
                            <p class="text-blue-700 text-sm">مثال: مشروع 1,apartment,10,percentage</p>
                            <p class="text-blue-700 text-sm">القيم المسموحة لـ type: apartment, floor, unit</p>
                            <p class="text-blue-700 text-sm">القيم المسموحة لـ type_discount: percentage, fixed</p>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-xl transition duration-300 transform hover:scale-105 font-semibold">
                    <i class="fas fa-sync-alt ml-2"></i>تحديث المشاريع
                </button>
            </form>
        </div>

        <!-- Last Upload Info -->
        @php
            $lastUpload = \App\Models\ProjectUpload::latest()->first();
        @endphp
        @if($lastUpload)
        <div class="bg-white rounded-xl p-4 border border-blue-200 max-w-2xl mx-auto mt-6">
            <h6 class="font-semibold text-gray-800 mb-3 text-right">آخر تحديث للمشاريع</h6>
            <div class="flex justify-between items-center">
                <div class="text-right">
                    <p class="text-sm text-gray-600">عدد المشاريع المضافة: <span class="font-semibold">{{ $lastUpload->projects_count }}</span></p>
                    <p class="text-xs text-gray-500">{{ $lastUpload->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
            </div>
        </div>
        @endif
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

<script>
// File upload handling
document.addEventListener('DOMContentLoaded', function() {
    const projectsFileInput = document.getElementById('projects_file');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileName = document.getElementById('fileName');
    const selectedFileName = document.getElementById('selectedFileName');
    const uploadForm = document.getElementById('projectsUploadForm');

    if (projectsFileInput && fileUploadArea) {
        projectsFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                selectedFileName.textContent = file.name;
                fileUploadArea.classList.add('hidden');
                fileName.classList.remove('hidden');
            }
        });

        fileUploadArea.addEventListener('click', function() {
            projectsFileInput.click();
        });
    }

    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!projectsFileInput.files.length) {
                showNotification('error', 'الرجاء اختيار ملف CSV');
                return;
            }

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i>جاري تحديث المشاريع...';
            submitBtn.disabled = true;

            fetch('{{ route("admin.projects.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                    setTimeout(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            location.reload();
                        }
                    }, 2000);
                } else {
                    showNotification('error', data.message);
                }
            })
            .catch(error => {
                showNotification('error', 'حدث خطأ أثناء رفع الملف');
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

function showNotification(type, message) {
    // Remove any existing notifications
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `custom-notification fixed top-4 left-4 z-50 p-4 rounded-xl text-white ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} ml-2"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);

    // Add animation
    notification.style.transform = 'translateX(-100%)';
    notification.style.transition = 'transform 0.3s ease-in-out';

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(-100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}
</script>

<style>
.hidden {
    display: none !important;
}

.dir-ltr {
    direction: ltr;
}

.glass-effect {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.space-x-reverse > :not([hidden]) ~ :not([hidden]) {
    --tw-space-x-reverse: 1;
}

/* Custom animations */
@keyframes slideIn {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(-100%);
        opacity: 0;
    }
}

.custom-notification {
    animation: slideIn 0.3s ease-in-out;
}

.custom-notification.hide {
    animation: slideOut 0.3s ease-in-out;
}

/* File upload area hover effects */
.border-dashed:hover {
    border-color: #10B981;
    background-color: #f0fdf4;
}

/* Button hover effects */
button:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease-in-out;
}

/* Table row hover effects */
tr:hover {
    background-color: #f9fafb;
    transition: background-color 0.2s ease-in-out;
}

/* Card hover effects */
.hover\\:scale-105:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease-in-out;
}
</style>
@endsection
