<?php

use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Inertia\Inertia;

Route::get('/auth/google', function () {
  return Socialite::driver('google')
    ->with(['prompt' => 'select_account'])
    ->redirect();
});

Route::get('/auth/google/callback', function () {
  $googleUser = Socialite::driver('google')->stateless()->user();

  $user = User::updateOrCreate(
    ['email' => $googleUser->getEmail()],
    [
      'name' => $googleUser->getName(),
      'user_name' => $googleUser->getId(),
      'avatar' => $googleUser->getAvatar(),
      'provider' => 'google',
      'password' => bcrypt(Str::random(16)),
      'roles_id' => 2,
    ]
  );

  // Login + Sanctum
  Auth::login($user);
  $user->forceFill(['login_at' => now()])->save();
  $tokenResult = $user->createToken('auth_token');
  $plainTextToken = $tokenResult->plainTextToken;

  // Gán expires_at cho token
  $tokenModel = PersonalAccessToken::find($tokenResult->accessToken->id);
  $tokenModel->expires_at = Carbon::now()->addHours(12);
  $tokenModel->save();

  return redirect('http://localhost:8000/auth?token=' . $plainTextToken . '&expires_at=' . urlencode($tokenModel->expires_at));
});
// Public routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/auth', function () {
  return Inertia::render('auth/Register');
})->name('auth');

Route::get('/admin/dashboard', function () {
  return Inertia::render('admin/analytics/index');
})->name('admin.dashboard');

// User routes (chỉ cho admin/manager sau này sẽ thêm middleware checkRole)
Route::middleware(['auth:sanctum', 'checkRole:1,2'])->prefix('admin')->group(function () {
  Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
  Route::get('/user/create', [UserController::class, 'create'])->name('admin.users.create');
  Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
  Route::post('/admin/users/{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
  Route::put('/users/{id}/status', [UserController::class, 'updateStatus'])->name('admin.users.status');
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

Route::prefix('contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index']);         
    Route::post('/', [ContactController::class, 'store']);        
    Route::put('/{id}/read', [ContactController::class, 'markAsRead']);
});