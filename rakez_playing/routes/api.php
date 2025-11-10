<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;





Route::post('/users', [UserController::class, 'checkAndStore']);
Route::post('/login', [UserController::class, 'login']);

// Or group routes with middleware
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
});