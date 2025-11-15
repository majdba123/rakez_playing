<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login - API style
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors([
                'phone' => 'رقم الجوال غير مسجل في النظام.',
            ]);
        }

        // Check if user is admin using model method
        if ($user->isAdmin()) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        // If user exists but not admin
        return back()->withErrors([
            'phone' => 'أنت لست مسؤولاً في النظام.',
        ]);
    }

    /**
     * Show admin dashboard (Admin only)
     */
    public function showAdminDashboard()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $users = User::all();
        $projectsCount = \App\Models\Projects::count();
        return view('admin.dashboard', compact('users', 'projectsCount'));
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
