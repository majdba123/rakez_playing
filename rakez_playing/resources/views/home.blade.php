@extends('layouts.app')

@section('title', 'RAKEZ العقارية - اربح مشروعك الحصري')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f8f6f4] to-[#e8e2d8] py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-12">
            <div class="w-24 h-24 bg-[#1f333a] rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-[#b2a292] shadow-lg">
                <i class="fas fa-gem text-[#b2a292] text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-[#1f333a] mb-4">RAKEZ العقارية</h1>
            <p class="text-lg text-[#1f333a] opacity-80 max-w-2xl mx-auto"> استكشف فرصتك العقارية</p>
        </div>

        <!-- Project Type Selection -->
        <div id="typeSelection" class="bg-white rounded-2xl p-8 shadow-lg border border-[#b2a292] mb-8">
            <h2 class="text-2xl font-bold text-[#1f333a] mb-8 text-center">اختر نوع المشروع</h2>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <!-- Apartment Box -->
                <div class="project-type-card" data-type="apartment">
                    <div class="card-icon bg-[#1f333a]">
                        <i class="fas fa-building text-[#b2a292] text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1f333a] mb-3">شقق سكنية</h3>
                    <p class="text-[#1f333a] opacity-70 mb-4">شقق سكنية بخصومات حصرية</p>
                    <div class="card-btn bg-[#1f333a] hover:bg-[#2a444d]">
                        <i class="fas fa-play ml-2"></i>اكتشف فرصتك
                    </div>
                </div>

                <!-- Floor Box -->
                <div class="project-type-card" data-type="floor">
                    <div class="card-icon bg-[#1f333a]">
                        <i class="fas fa-layer-group text-[#b2a292] text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1f333a] mb-3">دور كامل</h3>
                    <p class="text-[#1f333a] opacity-70 mb-4">دور كامل بخصم مميز</p>
                    <div class="card-btn bg-[#1f333a] hover:bg-[#2a444d]">
                        <i class="fas fa-play ml-2"></i>اكتشف فرصتك
                    </div>
                </div>

                <!-- Unit Box -->
                <div class="project-type-card" data-type="unit">
                    <div class="card-icon bg-[#1f333a]">
                        <i class="fas fa-home text-[#b2a292] text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1f333a] mb-3">فلل سكنية</h3>
                    <p class="text-[#1f333a] opacity-70 mb-4">وحدات  فلل تاون هاوس بيت هاوس </p>
                    <div class="card-btn bg-[#1f333a] hover:bg-[#2a444d]">
                        <i class="fas fa-play ml-2"></i>اكتشف فرصتك
                    </div>
                </div>
            </div>
        </div>

        <!-- Lucky Wheel Container -->
        <div id="wheelContainer" class="bg-white rounded-2xl p-8 shadow-lg border border-[#b2a292] mb-8 hidden">
            <h2 class="text-2xl font-bold text-[#1f333a] mb-8 text-center">  عرضك السكني <span id="selectedTypeText"></span></h2>

            <div class="relative mb-8">
                <!-- Wheel Container -->
                <div class="relative mx-auto" style="width: 350px; height: 350px;">
                    <!-- Wheel Base -->
                    <div class="absolute inset-0 bg-[#1f333a] rounded-full shadow-lg border-4 border-[#b2a292]"></div>

                    <!-- Wheel Sections -->
                    <div id="wheelSections" class="absolute inset-4 rounded-full overflow-hidden">
                        <!-- Sections will be populated by JavaScript -->
                    </div>

                    <!-- Center Circle -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-[#b2a292] rounded-full border-4 border-white shadow-lg z-20"></div>

                    <!-- Auto Spin Indicator -->
                    <div id="autoSpinIndicator" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-[#1f333a] rounded-full border-2 border-white text-white font-bold shadow-lg z-30 flex items-center justify-center">
                        <i class="fas fa-sync-alt fa-spin text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <button onclick="showTypeSelection()"
                        class="bg-[#1f333a] hover:bg-[#2a444d] text-white px-6 py-3 rounded-xl transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-2"></i>العودة للاختيار
                </button>
            </div>
        </div>

        <!-- Check Wins Section -->
        <div class="bg-white rounded-2xl p-8 shadow-lg border border-[#b2a292] mb-8">
            <h3 class="text-xl font-bold text-[#1f333a] mb-6 text-center">
                <i class="fas fa-trophy text-[#b2a292] ml-2"></i>تحقق من فوزك
            </h3>
            <div class="max-w-md mx-auto">
                <div class="flex space-x-4 space-x-reverse">
                    <input type="tel" id="checkPhone"
                           class="flex-1 px-4 py-3 bg-white border border-[#b2a292] rounded-xl focus:ring-2 focus:ring-[#1f333a] focus:border-[#1f333a] text-right text-[#1f333a] placeholder-[#1f333a]/50"
                           placeholder="أدخل رقم الجوال">
                    <button onclick="checkUserWins()"
                            class="bg-[#1f333a] hover:bg-[#2a444d] text-white px-6 py-3 rounded-xl transition-colors duration-200 font-medium">
                        <i class="fas fa-search ml-2"></i>تحقق
                    </button>
                </div>
            </div>
            <div id="winsResult" class="mt-6 hidden">
                <!-- Wins will be populated here -->
            </div>
        </div>


    </div>
</div>

<!-- Winning Result Modal -->
<div id="winModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-auto shadow-2xl border border-[#b2a292]">
        <div class="text-center">
            <!-- Confetti Animation Container -->
            <div id="confettiContainer" class="absolute inset-0 overflow-hidden pointer-events-none"></div>

            <div class="w-20 h-20 bg-[#1f333a] rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-[#b2a292]">
                <i class="fas fa-trophy text-[#b2a292] text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-[#1f333a] mb-4">خصمك جاهز الحين </h3>
            <div id="winResult" class="bg-[#f8f6f4] rounded-xl p-6 mb-6 border border-[#b2a292]">
                <!-- Win details will be populated here -->
            </div>
            <button onclick="claimPrize()"
                    class="w-full bg-[#1f333a] hover:bg-[#2a444d] text-white font-medium py-3 px-6 rounded-xl transition-colors duration-200">
                <i class="fas fa-check-circle ml-2"></i>فعل خصمك الأن
            </button>
        </div>
    </div>
</div>

<!-- Phone Input Modal -->
<div id="phoneModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-auto shadow-2xl border border-[#b2a292]">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-[#1f333a] rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-[#b2a292]">
                <i class="fas fa-mobile-alt text-[#b2a292] text-xl"></i>
            </div>
            <h3 class="text-xl font-bold text-[#1f333a] mb-2">فعل خصمك</h3>
            <p class="text-[#1f333a] opacity-70">أدخل رقم جوالك لتأكيد الفوز</p>
        </div>

        <form id="claimForm" class="space-y-6">
            @csrf
            <input type="hidden" id="selectedProjectId" name="project_id">

            <div class="space-y-2">
                <label for="phone" class="block text-sm font-medium text-[#1f333a] text-right">
                    <i class="fas fa-phone ml-2"></i>رقم الجوال
                </label>
                <input type="tel" id="phone" name="phone" required
                       class="w-full px-4 py-3 bg-white border border-[#b2a292] rounded-xl focus:ring-2 focus:ring-[#1f333a] focus:border-[#1f333a] text-right text-[#1f333a] placeholder-[#1f333a]/50 transition-colors duration-200"
                       placeholder="05XXXXXXXX">
            </div>

            <div class="flex space-x-4 space-x-reverse">
                <button type="submit"
                        class="flex-1 bg-[#1f333a] hover:bg-[#2a444d] text-white font-medium py-3 px-6 rounded-xl transition-colors duration-200">
                    <i class="fas fa-check ml-2"></i>تأكيد
                </button>
                <button type="button" onclick="closePhoneModal()"
                        class="flex-1 bg-[#f8f6f4] hover:bg-[#b2a292] hover:text-white text-[#1f333a] px-6 py-3 rounded-xl transition-colors duration-200 border border-[#b2a292]">
                    <i class="fas fa-times ml-2"></i>إلغاء
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="text-center">
        <div class="w-16 h-16 border-4 border-[#1f333a] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-[#1f333a] text-lg font-medium" id="loadingText">جاري الدوران...</p>
    </div>
</div>

<style>
.project-type-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #b2a292;
    transition: all 0.3s ease;
    transform: scale(1);
    cursor: pointer;
}

.project-type-card:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.card-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    border: 2px solid #b2a292;
}

.card-btn {
    color: white;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    width: 100%;
    display: block;
    cursor: pointer;
}

@keyframes confetti-fall {
    0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
    100% { transform: translateY(1000px) rotate(360deg); opacity: 0; }
}

.confetti {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #b2a292;
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
</style>

<script>
let currentProject = null;
let currentProjectType = '';
let isSpinning = false;

// Wheel sections with different prize levels for visual effect
const wheelSections = [
    { color: 'bg-[#b2a292]', label: 'جائزة', prize: 'مميز' },
    { color: 'bg-[#1f333a]', label: 'جائزة', prize: 'رائعة' },
    { color: 'bg-[#b2a292]', label: 'جائزة', prize: 'مذهلة' },
    { color: 'bg-[#1f333a]', label: 'جائزة', prize: 'حصري' },
    { color: 'bg-[#b2a292]', label: 'جائزة', prize: 'خاص' },
    { color: 'bg-[#1f333a]', label: 'جائزة', prize: 'فريدة' }
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
        'apartment': 'شقق ',
        'floor': 'أدوار',
        'unit': ' فلل(بنت هاوس & تاون هاوس)'
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
                <div class="w-full h-full ${section.color} clip-triangle"></div>
                <div class="absolute top-10 left-1/2 transform -translate-x-1/2 -rotate-90 text-white text-xs font-bold text-center" style="width: 70px;">
                    <div>${section.label}</div>
                    <div class="text-[#b2a292]">${section.prize}</div>
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
            <h4 class="text-xl font-bold text-[#1f333a] mb-3">${project.name}</h4>
            <div class="space-y-3 text-[#1f333a]">
                <div class="flex justify-between items-center">
                    <span>نوع المشروع:</span>
                    <span class="font-semibold">${typeNames[type]}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>الخصم:</span>
                    <span class="font-semibold">${project.formatted_value_discount}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>الفائزين السابقين:</span>
                    <span class="font-semibold">${project.winners_count}</span>
                </div>
            </div>
        </div>
    `;

    winModal.classList.remove('hidden');
}

// Create confetti effect
function createConfetti() {
    const container = document.getElementById('confettiContainer');
    const colors = ['#b2a292', '#1f333a', '#8a7a6a', '#2a444d'];

    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.width = Math.random() * 8 + 4 + 'px';
        confetti.style.height = Math.random() * 8 + 4 + 'px';
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

            let successMessage = 'مبروك! تم تسجيل فوزك بنجاح.';
            if (data.winner && data.winner.remaining_wins > 0) {
                successMessage += ` متبقي لك ${data.winner.remaining_wins} فرص للفوز.`;
            }

            alert(successMessage);
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
            let statusMessage = '';
            if (data.has_reached_limit) {
                statusMessage = `<div class="bg-red-100 border border-red-300 rounded-xl p-4 mb-4 text-center">
                    <i class="fas fa-info-circle text-red-600 text-lg mb-2"></i>
                    <p class="text-red-700">لقد وصلت إلى الحد الأقصى للفوز (3 مشاريع)</p>
                </div>`;
            } else {
                statusMessage = `<div class="bg-green-100 border border-green-300 rounded-xl p-4 mb-4 text-center">
                    <i class="fas fa-info-circle text-green-600 text-lg mb-2"></i>
                    <p class="text-green-700">متبقي لك ${data.remaining_wins} فرص للفوز</p>
                </div>`;
            }

            if (data.wins.length > 0) {
                winsResult.innerHTML = `
                    <div class="bg-[#f8f6f4] border border-[#b2a292] rounded-xl p-6">
                        ${statusMessage}
                        <h4 class="text-lg font-bold text-[#1f333a] mb-4 text-center">
                            <i class="fas fa-trophy text-[#b2a292] ml-2"></i>عدد الفوز: ${data.total_wins}/3
                        </h4>
                        <div class="space-y-4">
                            ${data.wins.map(win => `
                                <div class="bg-white rounded-lg p-4 border border-[#b2a292]">
                                    <h5 class="font-bold text-[#1f333a] text-right">${win.project.name}</h5>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-[#1f333a] opacity-70">الخصم:</span>
                                        <span class="font-semibold">${win.project.formatted_value_discount}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-[#1f333a] opacity-70">التاريخ:</span>
                                        <span class="text-[#1f333a] opacity-60 text-sm">${win.won_at}</span>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                winsResult.innerHTML = `
                    <div class="bg-yellow-100 border border-yellow-300 rounded-xl p-6 text-center">
                        <i class="fas fa-info-circle text-yellow-600 text-lg mb-2"></i>
                        <p class="text-yellow-700">لا توجد فوز مسجلة لهذا الرقم</p>
                        <p class="text-yellow-700 mt-2">متبقي لك 3 فرص للفوز</p>
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
