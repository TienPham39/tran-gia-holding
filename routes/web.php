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
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminContactController;
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

Route::post('/contacts', [ContactController::class, 'store'])
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
Route::middleware(['auth', 'checkRole:admin,marketing_manager'])->prefix('admin')->group(function () {
  Route::get('/dashboard', fn() => Inertia::render('admin/analytics/Index'))->name('admin.dashboard');
  Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
  Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
  Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
  Route::post('/users/{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
  Route::put('/users/{id}/status', [UserController::class, 'updateStatus'])->name('admin.users.status');
  Route::get('/profile', fn() => Inertia::render('admin/profile/index'))->name('admin.profile');

  Route::prefix('products')->name('admin.products.')->group(function () {
    Route::get('/', [AdminProductsController::class, 'index'])->name('index');

    // Product CRUD
    Route::get('/create', [AdminProductsController::class, 'create'])->name('create');
    Route::post('/', [AdminProductsController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminProductsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminProductsController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminProductsController::class, 'destroy'])->name('destroy');

    // Toggle highlight
    Route::post('/{id}/toggle-highlight', [AdminProductsController::class, 'toggleHighlight'])->name('toggleHighlight');
    // Toggle hot
    Route::post('/{id}/toggle-hot', [AdminProductsController::class, 'toggleHot'])->name('toggleHot');

    // Categories
    Route::get('/categories', [AdminProductsController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminProductsController::class, 'category'])->name('categories.create');
    Route::post('/categories', [AdminProductsController::class, 'createCategory'])->name('categories.store');
    Route::get('/types', [AdminProductsController::class, 'getProductTypes'])->name('types');
    Route::put('/types/{id}', [AdminProductsController::class, 'updateProductType'])->name('types.update');
    Route::delete('/types/{id}', [AdminProductsController::class, 'deleteProductType'])->name('types.delete');
  });

  Route::prefix('news')->name('admin.news.')->group(function () {

    Route::get('/', [AdminNewsController::class, 'index'])->name('index');

    Route::get('/create', [AdminNewsController::class, 'create'])->name('create');
    Route::post('/', [AdminNewsController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [AdminNewsController::class, 'edit'])->name('edit');
    Route::post('/{id}', [AdminNewsController::class, 'update'])->name('update');

    Route::post('/{id}/destroy', [AdminNewsController::class, 'destroy'])->name('destroy');

    Route::post('/upload-image', [AdminNewsController::class, 'uploadImage'])->name('uploadImage');
  });

  Route::prefix('contacts')->name('admin.contacts.')->group(function () {
    Route::get('/', [AdminContactController::class, 'index'])->name('index');

    Route::get('/{id}', [AdminContactController::class, 'show'])->name('show');

    Route::post('/{id}/mark-as-read', [AdminContactController::class, 'markAsRead'])
    ->name('markAsRead');

    Route::post('/{id}/destroy', [AdminContactController::class, 'destroy'])->name('destroy');
  });
});
