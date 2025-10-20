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
use App\Http\Middleware\VerifyCsrfToken;

Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (!file_exists($file)) {
        abort(404);
    }
    return response()->file($file);
})->where('path', '.*');

// Google login
Route::get('/auth/google', function () {
  return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
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

  Auth::login($user);
  $user->forceFill(['login_at' => now()])->save();
  $tokenResult = $user->createToken('auth_token');
  $plainTextToken = $tokenResult->plainTextToken;

  $tokenModel = PersonalAccessToken::find($tokenResult->accessToken->id);
  $tokenModel->expires_at = Carbon::now()->addHours(12);
  $tokenModel->save();

  return redirect('http://localhost:8000/auth?token=' . $plainTextToken . '&expires_at=' . urlencode($tokenModel->expires_at));
});

// Public routes
Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/register', [RegisterController::class, 'store'])->name('register')->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/auth', fn() => Inertia::render('auth/Register'))->name('auth');
Route::get('/admin/dashboard', fn() => Inertia::render('admin/analytics/index'))->name('admin.dashboard');

// Authenticated routes
Route::withoutMiddleware([VerifyCsrfToken::class])
  ->middleware(['auth:sanctum', 'check.token.expiry'])
  ->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/change-password', [UserController::class, 'changePassword']);
  });

// Admin
Route::middleware(['auth:sanctum', 'checkRole:1,2'])->prefix('admin')->group(function () {
  Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
  Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
  Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
  Route::post('/users/{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
  Route::put('/users/{id}/status', [UserController::class, 'updateStatus'])->name('admin.users.status');
  Route::get('/profile', fn() => Inertia::render('admin/profile/index'))->name('admin.profile');
});
