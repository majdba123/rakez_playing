<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/users', [UserController::class, 'checkAndStore']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Authenticated user routes (for all users)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [UserController::class, 'showHome'])->name('home');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
});

// Admin routes - protection handled in controllers
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [UserController::class, 'showAdminDashboard'])->name('dashboard');
    
    // Projects CRUD routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});