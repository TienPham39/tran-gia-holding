<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;

// User routes (chỉ cho admin/manager sau này sẽ thêm middleware checkRole)
Route::middleware(['auth:sanctum', 'checkRole:1,2'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}/status', [UserController::class, 'updateStatus']);
});

// Các route cho user đăng nhập (không giới hạn role)
Route::middleware(['auth:sanctum', 'check.token.expiry'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/change-password', [UserController::class, 'changePassword']);
    // routes/api.php
    Route::put('/user/reset-password', [UserController::class, 'resetPassword']);
    Route::put('/user/set-password', [UserController::class, 'setPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

});

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'store']);