<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// User routes (chỉ cho admin/manager sau này sẽ thêm middleware checkRole)
Route::middleware(['auth:sanctum', 'checkRole:1,2'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}/status', [UserController::class, 'updateStatus']);

    Route::get('/user', [AuthController::class, 'user']);
    // Logout chỉ cho user đã login
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'store']);

