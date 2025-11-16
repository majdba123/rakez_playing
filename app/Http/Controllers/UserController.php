<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projects;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show home page (public - no auth required)
     */
    public function showHome(Request $request)
    {
        return view('home');
    }

    /**
     * Show login form (for admin only)
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle admin login
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

        if ($user->isAdmin()) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

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
        $projectsCount = Projects::count();
        $winnersCount = Winner::count();
        $uniqueWinners = Winner::distinct('phone')->count('phone');

        return view('admin.dashboard', compact('users', 'projectsCount', 'winnersCount', 'uniqueWinners'));
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
