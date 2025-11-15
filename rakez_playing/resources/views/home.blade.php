@extends('layouts.app')

@section('title', 'RAKEZ العقارية - اربح مشروعك الحصري')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-12">
            <div class="w-28 h-28 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl border-4 border-white/20 animate-pulse">
                <i class="fas fa-gem text-white text-4xl"></i>
            </div>
            <h1 class="text-5xl font-bold text-white mb-4">RAKEZ العقارية</h1>
            <p class="text-xl text-blue-200 max-w-2xl mx-auto">اختر نوع المشروع وادر العجلة لتربح!</p>
        </div>

        <!-- Project Type Selection -->
        <div id="typeSelection" class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 mb-8">
            <h2 class="text-3xl font-bold text-white mb-8 text-center">اختر نوع المشروع</h2>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <!-- Apartment Box -->
                <div class="project-type-card" data-type="apartment">
                    <div class="card-icon bg-gradient-to-br from-blue-500 to-blue-600">
                        <i class="fas fa-building text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">شقق سكنية</h3>
                    <p class="text-blue-200 mb-4">شقق سكنية بخصومات حصرية</p>
                    <div class="card-btn bg-blue-500 hover:bg-blue-600">
                        <i class="fas fa-play ml-2"></i>ابدأ الدوران
                    </div>
                </div>

                <!-- Floor Box -->
                <div class="project-type-card" data-type="floor">
                    <div class="card-icon bg-gradient-to-br from-green-500 to-green-600">
                        <i class="fas fa-layer-group text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">دور كامل</h3>
                    <p class="text-blue-200 mb-4">دور كامل بخصم مميز</p>
                    <div class="card-btn bg-green-500 hover:bg-green-600">
                        <i class="fas fa-play ml-2"></i>ابدأ الدوران
                    </div>
                </div>

                <!-- Unit Box -->
                <div class="project-type-card" data-type="unit">
                    <div class="card-icon bg-gradient-to-br from-purple-500 to-purple-600">
                        <i class="fas fa-home text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">وحدات سكنية</h3>
                    <p class="text-blue-200 mb-4">وحدات سكنية بخصومات حصرية</p>
                    <div class="card-btn bg-purple-500 hover:bg-purple-600">
                        <i class="fas fa-play ml-2"></i>ابدأ الدوران
                    </div>
                </div>
            </div>
        </div>

        <!-- Lucky Wheel Container -->
        <div id="wheelContainer" class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 mb-8 hidden">
            <h2 class="text-3xl font-bold text-white mb-8 text-center">عجلة الحظ - <span id="selectedTypeText"></span></h2>

            <div class="relative mb-8">
                <!-- Wheel Container -->
                <div class="relative mx-auto" style="width: 400px; height: 400px;">
                    <!-- Wheel Base -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-700 rounded-full shadow-2xl border-8 border-yellow-400"></div>

                    <!-- Wheel Sections -->
                    <div id="wheelSections" class="absolute inset-4 rounded-full overflow-hidden">
                        <!-- Sections will be populated by JavaScript -->
                    </div>

                    <!-- Center Circle -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full border-4 border-white shadow-2xl z-20"></div>

                    <!-- Auto Spin Indicator -->
                    <div id="autoSpinIndicator" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full border-4 border-white text-white font-bold shadow-2xl z-30 flex items-center justify-center">
                        <i class="fas fa-sync-alt fa-spin text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <button onclick="showTypeSelection()"
                        class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-8 py-3 rounded-2xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-right ml-2"></i>العودة للاختيار
                </button>
            </div>
        </div>

        <!-- Check Wins Section -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 mb-8">
            <h3 class="text-2xl font-bold text-white mb-6 text-center">
                <i class="fas fa-trophy text-yellow-400 ml-2"></i>تحقق من فوزك
            </h3>
            <div class="max-w-md mx-auto">
                <div class="flex space-x-4 space-x-reverse">
                    <input type="tel" id="checkPhone"
                           class="flex-1 px-4 py-4 bg-white/20 border border-white/30 rounded-2xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-right text-white placeholder-white/70 text-lg"
                           placeholder="أدخل رقم الجوال">
                    <button onclick="checkUserWins()"
                            class="bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white px-8 py-4 rounded-2xl transition duration-300 transform hover:scale-105 shadow-lg font-semibold">
                        <i class="fas fa-search ml-2"></i>تحقق
                    </button>
                </div>
            </div>
            <div id="winsResult" class="mt-6 hidden">
                <!-- Wins will be populated here -->
            </div>
        </div>

        <!-- How to Play -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
            <h3 class="text-2xl font-bold text-white mb-8 text-center">كيفية اللعب</h3>
            <div class="grid md:grid-cols-3 gap-6 text-center">
                <div class="bg-white/10 rounded-2xl p-6 border border-white/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mouse-pointer text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-2">اختر النوع</h4>
                    <p class="text-blue-200">اختر نوع المشروع المفضل</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-6 border border-white/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sync-alt text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-2">ادر العجلة</h4>
                    <p class="text-blue-200">سيتم الدوران تلقائياً</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-6 border border-white/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gift text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-2">اربح الجائزة</h4>
                    <p class="text-blue-200">سجل رقمك لاستلام الجائزة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Winning Result Modal -->
<div id="winModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
    <div class="bg-gradient-to-br from-blue-600 to-purple-700 rounded-3xl p-8 max-w-md w-full mx-auto shadow-2xl border-4 border-yellow-400">
        <div class="text-center">
            <!-- Confetti Animation Container -->
            <div id="confettiContainer" class="absolute inset-0 overflow-hidden pointer-events-none"></div>

            <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-white shadow-2xl">
                <i class="fas fa-trophy text-white text-3xl"></i>
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">مبروك! لقد فزت</h3>
            <div id="winResult" class="bg-white/20 rounded-2xl p-6 mb-6 border border-white/30">
                <!-- Win details will be populated here -->
            </div>
            <button onclick="claimPrize()"
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-2xl transition duration-300 transform hover:scale-105 text-lg shadow-lg">
                <i class="fas fa-check-circle ml-2"></i>سجل فوزك
            </button>
        </div>
    </div>
</div>

<!-- Phone Input Modal -->
<div id="phoneModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
    <div class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-3xl p-8 max-w-md w-full mx-auto shadow-2xl border-4 border-white/30">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white">
                <i class="fas fa-mobile-alt text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">سجل فوزك</h3>
            <p class="text-green-200">أدخل رقم جوالك لتأكيد الفوز</p>
        </div>

        <form id="claimForm" class="space-y-6">
            @csrf
            <input type="hidden" id="selectedProjectId" name="project_id">

            <div class="space-y-2">
                <label for="phone" class="block text-sm font-medium text-white text-right">
                    <i class="fas fa-phone ml-2"></i>رقم الجوال
                </label>
                <input type="tel" id="phone" name="phone" required
                       class="w-full px-4 py-4 bg-white/20 border border-white/30 rounded-2xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 text-right text-white placeholder-white/70 text-lg transition duration-200"
                       placeholder="05XXXXXXXX">
            </div>

            <div class="flex space-x-4 space-x-reverse">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-2xl transition duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-check ml-2"></i>تأكيد
                </button>
                <button type="button" onclick="closePhoneModal()"
                        class="flex-1 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-4 rounded-2xl transition duration-300 transform hover:scale-105">
                    <i class="fas fa-times ml-2"></i>إلغاء
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center hidden z-50">
    <div class="text-center">
        <div class="w-20 h-20 border-4 border-yellow-400 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-white text-xl font-semibold" id="loadingText">جاري الدوران...</p>
    </div>
</div>

<style>
.project-type-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 1.5rem;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    transform: scale(1);
    cursor: pointer;
}

.project-type-card:hover {
    transform: scale(1.05);
    background: rgba(255, 255, 255, 0.15);
}

.card-icon {
    width: 5rem;
    height: 5rem;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.card-btn {
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
    transform: scale(1);
    width: 100%;
    display: block;
    cursor: pointer;
}

.card-btn:hover {
    transform: scale(1.05);
}

@keyframes confetti-fall {
    0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
    100% { transform: translateY(1000px) rotate(360deg); opacity: 0; }
}

.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #f00;
    animation: confetti-fall 3s linear forwards;
}

.wheel-spin {
    animation: spin 3s cubic-bezier(0.3, 0.1, 0.3, 1) forwards;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(var(--rotation-end, 1080deg)); }
}

.clip-triangle {
    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
}

.shadow-3xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}
</style>

<script>
let currentProject = null;
let currentProjectType = '';
let isSpinning = false;

// Wheel sections with different prize levels for visual effect
const wheelSections = [
    { color: 'from-yellow-400 to-orange-500', label: 'جائزة', prize: 'مميز' },
    { color: 'from-green-400 to-green-500', label: 'جائزة', prize: 'رائعة' },
    { color: 'from-blue-400 to-blue-500', label: 'جائزة', prize: 'مذهلة' },
    { color: 'from-purple-400 to-purple-500', label: 'جائزة', prize: 'حصري' },
    { color: 'from-pink-400 to-pink-500', label: 'جائزة', prize: 'خاص' },
    { color: 'from-teal-400 to-teal-500', label: 'جائزة', prize: 'فريدة' }
];

// Show type selection and hide wheel
function showTypeSelection() {
    document.getElementById('wheelContainer').classList.add('hidden');
    document.getElementById('typeSelection').classList.remove('hidden');
}

// Show wheel for selected type and auto spin
function showWheelForType(type) {
    console.log('Showing wheel for type:', type);

    const typeNames = {
        'apartment': 'شقق سكنية',
        'floor': 'دور كامل',
        'unit': 'وحدات سكنية'
    };

    currentProjectType = type;

    // Update UI
    document.getElementById('selectedTypeText').textContent = typeNames[type];
    document.getElementById('typeSelection').classList.add('hidden');
    document.getElementById('wheelContainer').classList.remove('hidden');

    // Initialize wheel and auto spin
    initializeWheel();
    setTimeout(() => {
        spinWheel();
    }, 1000); // Auto spin after 1 second
}

// Initialize wheel
function initializeWheel() {
    console.log('Initializing wheel...');
    const wheelContainer = document.getElementById('wheelSections');
    const sectionAngle = 360 / wheelSections.length;

    // Clear previous sections
    wheelContainer.innerHTML = '';

    wheelSections.forEach((section, index) => {
        const sectionElement = document.createElement('div');
        const rotation = index * sectionAngle;

        sectionElement.className = `absolute top-0 left-0 w-full h-full origin-center`;
        sectionElement.style.transform = `rotate(${rotation}deg)`;
        sectionElement.innerHTML = `
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-1/2 h-1/2 origin-bottom" style="transform: rotate(${sectionAngle}deg);">
                <div class="w-full h-full bg-gradient-to-br ${section.color} clip-triangle"></div>
                <div class="absolute top-12 left-1/2 transform -translate-x-1/2 -rotate-90 text-white text-xs font-bold text-center" style="width: 80px;">
                    <div>${section.label}</div>
                    <div class="text-yellow-300">${section.prize}</div>
                </div>
            </div>
        `;

        wheelContainer.appendChild(sectionElement);
    });

    console.log('Wheel initialized with', wheelSections.length, 'sections');
}

// Spin the wheel automatically
async function spinWheel() {
    console.log('Auto spinning wheel...');

    if (isSpinning) {
        console.log('Wheel is already spinning');
        return;
    }

    isSpinning = true;
    const wheel = document.getElementById('wheelSections');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');

    // Show loading
    loadingText.textContent = 'جاري الدوران...';
    loadingOverlay.classList.remove('hidden');

    try {
        console.log('Starting auto spin animation...');
        // Calculate random rotation (multiple full rotations + random offset)
        const targetRotation = 360 * 5 + Math.random() * 360;

        // Apply spin animation
        wheel.style.setProperty('--rotation-end', `${targetRotation}deg`);
        wheel.classList.add('wheel-spin');

        // Wait for animation to complete
        await new Promise(resolve => setTimeout(resolve, 3000));

        console.log('Fetching project for type:', currentProjectType);
        // Get random project of the selected type
        const response = await fetch(`/api/game/projects/${currentProjectType}`, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await response.json();
        console.log('API response:', data);

        if (data.success) {
            currentProject = data.project;
            console.log('Project received:', currentProject);
            showWinResult(data.project, currentProjectType);
            createConfetti();
        } else {
            alert('خطأ: ' + data.message);
        }

    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
    } finally {
        // Reset wheel after a delay
        setTimeout(() => {
            console.log('Resetting wheel...');
            wheel.classList.remove('wheel-spin');
            wheel.style.transform = 'rotate(0deg)';
            loadingOverlay.classList.add('hidden');
            isSpinning = false;
        }, 1000);
    }
}

// Show win result
function showWinResult(project, type) {
    console.log('Showing win result for project:', project);
    const winModal = document.getElementById('winModal');
    const winResult = document.getElementById('winResult');

    const typeNames = {
        'apartment': 'شقة سكنية',
        'floor': 'دور كامل',
        'unit': 'وحدة سكنية'
    };

    winResult.innerHTML = `
        <div class="text-center">
            <h4 class="text-2xl font-bold text-white mb-3">${project.name}</h4>
            <div class="space-y-3 text-white/90">
                <div class="flex justify-between items-center">
                    <span>نوع المشروع:</span>
                    <span class="font-semibold text-yellow-300">${typeNames[type]}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>الخصم:</span>
                    <span class="font-semibold text-green-300">${project.formatted_value_discount}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>الفائزين السابقين:</span>
                    <span class="font-semibold ${project.winners_count > 0 ? 'text-orange-300' : 'text-green-300'}">${project.winners_count}</span>
                </div>
            </div>
        </div>
    `;

    winModal.classList.remove('hidden');
}

// Create confetti effect
function createConfetti() {
    const container = document.getElementById('confettiContainer');
    const colors = ['#FFD700', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'];

    for (let i = 0; i < 100; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.width = Math.random() * 10 + 5 + 'px';
        confetti.style.height = Math.random() * 10 + 5 + 'px';
        confetti.style.animationDelay = Math.random() * 2 + 's';
        container.appendChild(confetti);

        // Remove confetti after animation
        setTimeout(() => confetti.remove(), 3000);
    }
}

// Claim prize
function claimPrize() {
    document.getElementById('winModal').classList.add('hidden');
    showPhoneModal();
}

// Show phone input modal
function showPhoneModal() {
    document.getElementById('selectedProjectId').value = currentProject.id;
    document.getElementById('phone').value = '';
    document.getElementById('phoneModal').classList.remove('hidden');
}

// Close phone modal
function closePhoneModal() {
    document.getElementById('phoneModal').classList.add('hidden');
}

// Handle claim form submission
document.getElementById('claimForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const loadingOverlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');

    try {
        loadingText.textContent = 'جاري تسجيل الفوز...';
        loadingOverlay.classList.remove('hidden');

        const response = await fetch('/api/game/claim-project', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            closePhoneModal();
            loadingOverlay.classList.add('hidden');
            showSuccessMessage('مبروك! تم تسجيل فوزك بنجاح.');
        } else {
            loadingOverlay.classList.add('hidden');
            alert('خطأ: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        loadingOverlay.classList.add('hidden');
        alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
    }
});

// Check user wins
async function checkUserWins() {
    const phone = document.getElementById('checkPhone').value.trim();

    if (!phone) {
        alert('يرجى إدخال رقم الجوال');
        return;
    }

    try {
        showLoading('جاري التحقق...');

        const response = await fetch(`/api/game/user-wins?phone=${encodeURIComponent(phone)}`, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await response.json();
        const winsResult = document.getElementById('winsResult');

        if (data.success) {
            if (data.wins.length > 0) {
                winsResult.innerHTML = `
                    <div class="bg-white/20 border border-white/30 rounded-2xl p-6">
                        <h4 class="text-xl font-bold text-white mb-4 text-center">
                            <i class="fas fa-trophy text-yellow-400 ml-2"></i>عدد الفوز: ${data.total_wins}
                        </h4>
                        <div class="space-y-4">
                            ${data.wins.map(win => `
                                <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                                    <h5 class="font-bold text-lg text-white text-right">${win.project.name}</h5>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-white/80">الخصم:</span>
                                        <span class="font-semibold text-green-300">${win.project.formatted_value_discount}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-white/80">التاريخ:</span>
                                        <span class="text-white/60 text-sm">${win.won_at}</span>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                winsResult.innerHTML = `
                    <div class="bg-yellow-500/20 border border-yellow-400/30 rounded-2xl p-6 text-center">
                        <i class="fas fa-info-circle text-yellow-300 text-2xl mb-2"></i>
                        <p class="text-yellow-200">لا توجد فوز مسجلة لهذا الرقم</p>
                    </div>
                `;
            }
            winsResult.classList.remove('hidden');
        } else {
            alert('خطأ: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
    } finally {
        hideLoading();
    }
}

// Utility functions
function showLoading(message) {
    const loadingOverlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');
    loadingText.textContent = message;
    loadingOverlay.classList.remove('hidden');
}

function hideLoading() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.classList.add('hidden');
}

function showSuccessMessage(message) {
    alert(message);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, setting up event listeners...');

    // Add event listeners to project type cards
    document.querySelectorAll('.project-type-card').forEach(card => {
        card.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            console.log('Project type card clicked:', type);
            showWheelForType(type);
        });
    });

    // Test if elements exist
    console.log('Type selection:', document.getElementById('typeSelection'));
    console.log('Wheel container:', document.getElementById('wheelContainer'));
    console.log('Wheel sections:', document.getElementById('wheelSections'));
});
</script>
@endsection
