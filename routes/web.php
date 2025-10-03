<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/auth/google', function () {
  return Socialite::driver('google')
    ->with(['prompt' => 'select_account'])
    ->redirect();
});

Route::get('/auth/google/callback', function () {
  $googleUser = Socialite::driver('google')->stateless()->user();

  $user = User::firstOrCreate(
    ['email' => $googleUser->getEmail()],
    [
      'name' => $googleUser->getName(),
      'user_name' => $googleUser->getId(),
      'password' => bcrypt(\Str::random(16)),
      'avatar' => $googleUser->getAvatar(),
      'roles_id' => 2,
    ]
  );

  // Login + Sanctum
  Auth::login($user);
  $token = $user->createToken('auth_token')->plainTextToken;

  return redirect('http://localhost:8000/auth?token=' . $token);
});

// Route catch-all của Vue phải đặt cuối cùng
Route::view('/{any}', 'app')->where('any', '^(?!api).*$');

