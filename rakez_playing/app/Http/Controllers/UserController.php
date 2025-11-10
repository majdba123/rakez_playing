<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Check if user is admin
     */
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->type != 1) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Show home page
     */
    public function showHome(Request $request)
    {
        $user = Auth::user();
        $user_exists = session('user_exists', false);
        return view('home', compact('user', 'user_exists'));
    }

    /**
     * Show profile page
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Show admin dashboard
     */
    public function showAdminDashboard()
    {
        $this->checkAdmin();
        
        $users = User::all();
        $projectsCount = Projects::count();
        return view('admin.dashboard', compact('users', 'projectsCount'));
    }

    /**
     * Check phone and login or register user
     */
    public function checkAndStore(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Check if phone already exists
        $existingUser = User::where('phone', $request->phone)->first();
        
        if ($existingUser) {
            // Auto login if user exists
            Auth::login($existingUser);
            session(['user_exists' => true]);
            
            // Check if user is admin (type = 1)
            if ($existingUser->type == 1) {
                return response()->json([
                    'success' => true,
                    'user_exists' => true,
                    'is_admin' => true,
                    'redirect' => route('admin.dashboard')
                ]);
            }
            
            // Regular existing user
            return response()->json([
                'success' => true,
                'user_exists' => true,
                'is_admin' => false,
                'redirect' => route('home')
            ]);
        }

        // Create new user (always regular user)
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make(rand(100000, 999999)),
            'type' => 0, // Always set as regular user
        ]);

        // Auto login after registration
        Auth::login($user);
        session(['user_exists' => false]);

        return response()->json([
            'success' => true,
            'user_exists' => false,
            'is_admin' => false,
            'redirect' => route('home')
        ], 201);
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
}