@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <i class="fas fa-home text-4xl text-blue-600 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800">Welcome</h2>
        <p class="text-gray-600 mt-2">Hello, {{ Auth::user()->name }}!</p>
    </div>

    <!-- User Information -->
    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Information</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Name:</span>
                <span class="text-gray-900">{{ Auth::user()->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Phone:</span>
                <span class="text-gray-900">{{ Auth::user()->phone }}</span>
            </div>
        </div>
        
        <!-- Profile Link -->
        <div class="mt-4 text-center">
            <a href="{{ route('profile') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 inline-block">
                <i class="fas fa-user mr-2"></i>View Full Profile
            </a>
        </div>
    </div>

    <!-- Game Status Section -->
    <div class="rounded-lg p-6 text-center mb-6">
        @if($has_played_game)
            <!-- User has already played - Show only message (NO BUTTON) -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-info-circle text-3xl text-yellow-600 mr-3"></i>
                    <h4 class="text-xl font-bold text-yellow-800">Game Status</h4>
                </div>
                <p class="text-yellow-700 text-lg mb-4">You have already played the game!</p>
                <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded-lg inline-block">
                    <i class="fas fa-ban mr-2"></i>Game Completed - Cannot Play Again
                </div>
            </div>
        @else
            <!-- User hasn't played - Show game button -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-gamepad text-3xl text-green-600 mr-3"></i>
                    <h4 class="text-xl font-bold text-green-800">Ready to Play!</h4>
                </div>
                <p class="text-green-700 text-lg mb-4">Click the button below to play the cube game and win a project!</p>
                <button onclick="startCubeGame()" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 transform hover:scale-105 text-lg">
                    <i class="fas fa-cube mr-2"></i>Click to Play Cube Game
                </button>
            </div>
        @endif
    </div>

    <!-- Selected Project Display (if user has played) -->
    @if($has_played_game)
        @php
            $selectedProject = \App\Helpers\GameHelper::getUserSelectedProject();
        @endphp
        @if($selectedProject)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="text-center">
                <i class="fas fa-gift text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-bold text-blue-800 mb-2">Your Winning Project</h3>
                <p class="text-blue-700 mb-4">Here's the project you won:</p>
                <div class="bg-white rounded-lg p-4 inline-block max-w-md">
                    <h4 class="font-bold text-lg text-gray-800">{{ $selectedProject->project->name }}</h4>
                    <p class="text-sm text-gray-600">Type: {{ $selectedProject->project->formatted_type }}</p>
                    <p class="text-sm text-gray-600">Discount: {{ $selectedProject->project->formatted_value_discount }} ({{ $selectedProject->project->formatted_discount_type }})</p>
                    <p class="text-xs text-gray-500 mt-2">Selected on: {{ $selectedProject->selected_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
        @endif
    @endif

    <!-- Cube Game Modal -->
    <div id="cubeGameModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 max-w-md mx-4 w-full">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Cube Game</h3>
                <p class="text-gray-600">Click on a cube to reveal your project!</p>
            </div>

            <div id="gameContainer" class="grid grid-cols-3 gap-4 mb-6">
                <!-- Cubes will be populated here -->
            </div>

            <div id="gameResult" class="hidden text-center">
                <!-- Result will be shown here -->
            </div>

            <div class="text-center">
                <button onclick="closeGameModal()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Logout -->
    <div class="text-center">
        <form action="{{ route('logout') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </button>
        </form>
    </div>
</div>


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
                alert('You have already played the game!');
            } else {
                alert('Error: ' + data.message);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    }
}

function showCubeGame(projects) {
    const gameContainer = document.getElementById('gameContainer');
    const gameModal = document.getElementById('cubeGameModal');
    
    // Clear previous cubes
    gameContainer.innerHTML = '';
    
    // Create cubes
    projects.forEach((project, index) => {
        const cube = document.createElement('div');
        cube.className = 'bg-blue-500 hover:bg-blue-600 text-white font-bold text-2xl h-20 rounded-lg cursor-pointer transition duration-200 transform hover:scale-105 flex items-center justify-center';
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
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
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
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-center mb-3">
                <i class="fas fa-trophy text-3xl text-green-600 mr-2"></i>
                <h4 class="text-xl font-bold text-green-800">Congratulations!</h4>
            </div>
            <p class="text-green-700 mb-3">You won:</p>
            <div class="bg-white rounded-lg p-3 border border-green-200">
                <h5 class="font-bold text-lg text-gray-800">${project.name}</h5>
                <p class="text-sm text-gray-600">Type: ${project.formatted_type}</p>
                <p class="text-sm text-gray-600">Discount: ${project.formatted_value_discount} (${project.formatted_discount_type})</p>
            </div>
            <p class="text-green-600 text-sm mt-3">Page will refresh in 3 seconds...</p>
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