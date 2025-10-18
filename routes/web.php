<?php

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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/auth', function () {
    return Inertia::render('auth/Register');
})->name('auth');

Route::get('/admin/dashboard', function () {
    return Inertia::render('admin/admin');
})->name('admin.dashboard');