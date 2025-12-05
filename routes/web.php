<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\ProductBDSController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Client\CommunityController;
use App\Http\Controllers\Client\CareerController;
use App\Http\Controllers\Admin\AdminNewsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\VerifyCsrfToken;

// Public routes
Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/register', [RegisterController::class, 'store'])->name('register')->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/auth', fn() => Inertia::render('auth/Register'))->name('auth');

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

Route::post('/contact', [ContactController::class, 'store'])
  ->name('contact.store');

Route::get('/product', [ProductBDSController::class, 'index'])->name('client.product');
Route::get('/product/detail/{id}', [ProductBDSController::class, 'show'])
  ->name('client.product.show');

Route::get('/service', [ServiceController::class, 'index'])->name('client.service');
Route::get('/community', [CommunityController::class, 'index'])
  ->name('client.community');
Route::get('/career', [CareerController::class, 'index'])
  ->name('client.career');

// Authenticated routes
Route::withoutMiddleware([VerifyCsrfToken::class])
  ->middleware(['auth:sanctum', 'check.token.expiry'])
  ->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/change-password', [UserController::class, 'changePassword']);
  });

// Admin
Route::middleware(['auth', 'checkRole:1,2'])->prefix('admin')->group(function () {
  Route::get('/dashboard', fn() => Inertia::render('admin/analytics/index'))->name('admin.dashboard');
  Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
  Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
  Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
  Route::post('/users/{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
  Route::put('/users/{id}/status', [UserController::class, 'updateStatus'])->name('admin.users.status');
  Route::get('/profile', fn() => Inertia::render('admin/profile/index'))->name('admin.profile');
  Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
  Route::put('/contacts/{id}/mark-as-read', [ContactController::class, 'markAsRead'])->name('admin.contacts.markAsRead');

  Route::get('/news', [AdminNewsController::class, 'index'])->name('admin.news.index');
  Route::get('/news/create', [AdminNewsController::class, 'create'])->name('admin.news.create');
  Route::post('/news', [AdminNewsController::class, 'store'])->name('admin.news.store');
  Route::post('/news/upload-image', [AdminNewsController::class, 'uploadImage']);
});
