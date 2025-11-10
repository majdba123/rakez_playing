@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <i class="fas fa-user text-4xl text-blue-600 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800">Your Profile</h2>
    </div>

    <!-- User Information -->
    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Information</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <p class="text-gray-900 text-lg">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <p class="text-gray-900 text-lg">{{ Auth::user()->phone }}</p>
            </div>
            @if(Auth::user()->email)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900 text-lg">{{ Auth::user()->email }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Back to Home -->
    <div class="text-center">
        <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Home
        </a>
    </div>
</div>
@endsection