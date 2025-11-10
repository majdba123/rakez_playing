@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
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
        @if(session('user_exists'))
            <!-- Existing User - Already Played (NO BUTTON) -->
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
            <!-- New User - Click to Game (WITH BUTTON) -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-gamepad text-3xl text-green-600 mr-3"></i>
                    <h4 class="text-xl font-bold text-green-800">Ready to Play!</h4>
                </div>
                <p class="text-green-700 text-lg mb-4">Click the button below to start playing!</p>
                <button onclick="startGame()" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 transform hover:scale-105 text-lg">
                    <i class="fas fa-play mr-2"></i>Click to Game
                </button>
            </div>
        @endif
    </div>

    <!-- Logout Button (using POST form) -->
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
function startGame() {
    // Add your game logic here
    alert('Starting the game... Enjoy!');
    // You can redirect to game page or show game interface
    // window.location.href = '/game';
}
</script>
@endsection