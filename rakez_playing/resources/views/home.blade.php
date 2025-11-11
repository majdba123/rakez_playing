@extends('layouts.app')

@section('title', 'الرئيسية - RAKEZ العقارية')

@section('content')
<div class="glass-effect rounded-3xl shadow-2xl overflow-hidden p-8">
    <!-- Welcome Section -->
    <div class="text-center mb-12">
        <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-home text-white text-3xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-3">مرحباً بك في RAKEZ العقارية</h2>
        <p class="text-xl text-gray-600">أهلاً وسهلاً, {{ Auth::user()->name }}!</p>
    </div>

    <!-- User Information Card -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 mb-8 border border-blue-100">
        <h3 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-user-circle ml-2 text-blue-600"></i>معلوماتك الشخصية
        </h3>
        <div class="grid md:grid-cols-2 gap-6 text-right">
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-gray-700">الاسم الكامل:</span>
                    <span class="text-gray-900 font-semibold">{{ Auth::user()->name }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-gray-700">رقم الجوال:</span>
                    <span class="text-gray-900 font-semibold">{{ Auth::user()->phone }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Status Section -->
    <div class="rounded-2xl p-2 mb-8">
        @if($has_played_game)
            <!-- User has already played -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-8">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center ml-4">
                        <i class="fas fa-trophy text-yellow-600 text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <h4 class="text-2xl font-bold text-yellow-800">تهانينا!</h4>
                        <p class="text-yellow-700">لقد شاركت في اللعبة بالفعل</p>
                    </div>
                </div>
                
                @php
                    $selectedProject = \App\Helpers\GameHelper::getUserSelectedProject();
                @endphp
                @if($selectedProject)
                <div class="bg-white rounded-xl p-6 mt-6 border border-yellow-200">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 text-right">المشروع الذي فزت به:</h5>
                    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl p-1">
                        <div class="bg-white rounded-lg p-4 text-right">
                            <h6 class="font-bold text-lg text-gray-800">{{ $selectedProject->project->name }}</h6>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-sm text-gray-600">النوع:</span>
                                <span class="font-semibold text-blue-600">{{ $selectedProject->project->formatted_type }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-gray-600">الخصم:</span>
                                <span class="font-semibold text-green-600">{{ $selectedProject->project->formatted_value_discount }} ({{ $selectedProject->project->formatted_discount_type }})</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-3 text-left">
                                <i class="fas fa-clock ml-1"></i>
                                {{ $selectedProject->selected_at->format('Y-m-d H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @else
            <!-- User hasn't played -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-8 text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center ml-6 cube-animation">
                        <i class="fas fa-cube text-green-600 text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <h4 class="text-2xl font-bold text-green-800">لعبة المكعبات</h4>
                        <p class="text-green-700">اختر مكعباً واربح مشروعاً حصرياً!</p>
                    </div>
                </div>
                
                <p class="text-green-600 text-lg mb-8">انقر على الزر أدناه للعب وربح مشروع عقاري مميز</p>
                
                <button onclick="startCubeGame()" 
                        class="btn-primary text-white font-bold py-4 px-12 rounded-xl transition duration-200 text-xl transform hover:scale-105 shadow-lg">
                    <i class="fas fa-play ml-3"></i>ابدأ اللعبة الآن
                </button>
                
                <div class="mt-6 text-sm text-green-600">
                    <i class="fas fa-gift ml-1"></i>
                    فرصتك لربح مشروع حصري من RAKEZ العقارية
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-200">
        <h4 class="text-xl font-bold text-gray-800 mb-6 text-right">
            <i class="fas fa-bolt ml-2 text-blue-600"></i>إجراءات سريعة
        </h4>
        <div class="grid md:grid-cols-2 gap-4">
            <a href="{{ route('profile') }}" 
               class="bg-white hover:bg-blue-50 border border-blue-200 rounded-xl p-4 text-center transition duration-200 transform hover:scale-105">
                <i class="fas fa-user-edit text-blue-600 text-2xl mb-2"></i>
                <div class="font-semibold text-gray-800">الملف الشخصي</div>
                <div class="text-sm text-gray-600">تعديل معلوماتك</div>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="bg-white hover:bg-red-50 border border-red-200 rounded-xl p-4 text-center transition duration-200 transform hover:scale-105">
                @csrf
                <button type="submit" class="w-full">
                    <i class="fas fa-sign-out-alt text-red-600 text-2xl mb-2"></i>
                    <div class="font-semibold text-gray-800">تسجيل الخروج</div>
                    <div class="text-sm text-gray-600">خروج آمن من النظام</div>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Cube Game Modal -->
<div id="cubeGameModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50 p-4">
    <div class="glass-effect rounded-3xl p-8 max-w-md w-full mx-auto shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-cube text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">لعبة المكعبات</h3>
            <p class="text-gray-600">اختر أحد المكعبات لاكتشاف مشروعك</p>
        </div>

        <div id="gameContainer" class="grid grid-cols-3 gap-6 mb-8">
            <!-- Cubes will be populated here -->
        </div>

        <div id="gameResult" class="hidden text-center">
            <!-- Result will be shown here -->
        </div>

        <div class="text-center">
            <button onclick="closeGameModal()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition duration-200">
                <i class="fas fa-times ml-2"></i>إغلاق
            </button>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Cube Game Functions
async function startCubeGame() {
    try {
        const response = await fetch('/api/game/projects', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            showCubeGame(data.projects);
        } else {
            if (data.has_played) {
                alert('لقد شاركت في اللعبة بالفعل!');
            } else {
                alert('خطأ: ' + data.message);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
    }
}

function showCubeGame(projects) {
    const gameContainer = document.getElementById('gameContainer');
    const gameModal = document.getElementById('cubeGameModal');
    
    // Clear previous cubes
    gameContainer.innerHTML = '';
    
    // Create cubes with different colors and animations
    const cubeColors = [
        'from-blue-500 to-blue-600',
        'from-green-500 to-green-600', 
        'from-purple-500 to-purple-600',
        'from-orange-500 to-orange-600',
        'from-pink-500 to-pink-600',
        'from-teal-500 to-teal-600'
    ];
    
    projects.forEach((project, index) => {
        const cube = document.createElement('div');
        cube.className = `bg-gradient-to-br ${cubeColors[index]} text-white font-bold text-2xl h-24 rounded-2xl cursor-pointer transition duration-300 transform hover:scale-110 flex items-center justify-center shadow-lg cube-animation`;
        cube.innerHTML = '<i class="fas fa-cube"></i>';
        cube.onclick = () => selectProject(project.id, project);
        
        gameContainer.appendChild(cube);
    });
    
    // Show modal
    gameModal.classList.remove('hidden');
}

async function selectProject(projectId, project) {
    try {
        const response = await fetch('/api/game/select-project', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ project_id: projectId })
        });

        const data = await response.json();

        if (data.success) {
            showGameResult(data.selected_project);
            // Reload the page after 3 seconds to show the updated status
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        } else {
            alert('خطأ: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
    }
}

function showGameResult(project) {
    const gameContainer = document.getElementById('gameContainer');
    const gameResult = document.getElementById('gameResult');
    
    // Hide cubes
    gameContainer.classList.add('hidden');
    
    // Show result
    gameResult.classList.remove('hidden');
    gameResult.innerHTML = `
        <div class="bg-gradient-to-r from-green-50 to-emerald-100 border border-green-200 rounded-2xl p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center ml-4">
                    <i class="fas fa-trophy text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-green-800">مبروك! لقد فزت</h4>
            </div>
            <p class="text-green-700 mb-4 text-right">مشروعك الحصري:</p>
            <div class="bg-white rounded-xl p-4 border border-green-200 text-right">
                <h5 class="font-bold text-lg text-gray-800">${project.name}</h5>
                <div class="flex items-center justify-between mt-3">
                    <span class="text-sm text-gray-600">النوع:</span>
                    <span class="font-semibold text-blue-600">${project.formatted_type}</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-sm text-gray-600">الخصم:</span>
                    <span class="font-semibold text-green-600">${project.formatted_value_discount} (${project.formatted_discount_type})</span>
                </div>
            </div>
            <p class="text-green-600 text-sm mt-4 text-center">جاري تحديث الصفحة...</p>
        </div>
    `;
}

function closeGameModal() {
    const gameModal = document.getElementById('cubeGameModal');
    gameModal.classList.add('hidden');
    
    // Reset game state
    document.getElementById('gameContainer').classList.remove('hidden');
    document.getElementById('gameResult').classList.add('hidden');
}
</script>
@endsection
@endsection