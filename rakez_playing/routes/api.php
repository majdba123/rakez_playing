<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// API routes are automatically prefixed with '/api'
Route::post('/users', [UserController::class, 'store']);
Route::post('/check-phone', [UserController::class, 'checkPhone']);

// You can also use resource routes
// Route::apiResource('users', UserController::class);

// Or group routes with middleware
Route::middleware(['auth:sanctum'])->group(function () {
    // Protected routes here
    Route::get('/profile', [UserController::class, 'profile']);
});