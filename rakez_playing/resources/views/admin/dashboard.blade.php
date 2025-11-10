@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <div class="text-center mb-8">
        <i class="fas fa-crown text-4xl text-yellow-500 mb-4"></i>
        <h2 class="text-3xl font-bold text-gray-800">Admin Dashboard</h2>
        <p class="text-gray-600 mt-2">Welcome, {{ Auth::user()->name }}! (Admin)</p>
    </div>

    <!-- Admin Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <i class="fas fa-users text-3xl text-blue-600 mb-3"></i>
            <h3 class="text-xl font-bold text-blue-800">Total Users</h3>
            <p class="text-2xl font-semibold text-blue-600">{{ $users->count() }}</p>
        </div>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
            <i class="fas fa-user-shield text-3xl text-green-600 mb-3"></i>
            <h3 class="text-xl font-bold text-green-800">Admins</h3>
            <p class="text-2xl font-semibold text-green-600">{{ $users->where('type', 1)->count() }}</p>
        </div>
        
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
            <i class="fas fa-user text-3xl text-purple-600 mb-3"></i>
            <h3 class="text-xl font-bold text-purple-800">Regular Users</h3>
            <p class="text-2xl font-semibold text-purple-600">{{ $users->where('type', 0)->count() }}</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->type == 1)
                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Admin</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="mt-8 bg-gray-50 rounded-lg p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Admin Actions</h4>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-home mr-2"></i>Go to Home
            </a>
            <!-- Add this to the admin actions section -->
            <a href="{{ route('admin.projects.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-building mr-2"></i>Manage Projects
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection