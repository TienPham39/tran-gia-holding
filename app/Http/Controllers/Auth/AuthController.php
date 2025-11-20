<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "email" => "required|email",
      "password" => "required|string|min:6",
    ], [
      "email.required" => "Vui lòng nhập email",
      "email.email" => "Email không đúng định dạng",
      "password.required" => "Vui lòng nhập mật khẩu",
      "password.string" => "Mật khẩu phải là chuỗi ký tự",
      "password.min" => "Mật khẩu phải có ít nhất 6 ký tự",
    ]);

    // Nếu validate fail → trả JSON 422
    if ($validator->fails()) {
      return response()->json([
        "errors" => $validator->errors(),
      ], 422);
    }

    // Nếu sai tài khoản hoặc mật khẩu
    if (!Auth::attempt($request->only('email', 'password'))) {
      return response()->json([
        "message" => "Sai email hoặc mật khẩu"
      ], 401);
    }

    $user = Auth::user();
    $user->update(['login_at' => now()]);

    $tokenResult = $user->createToken('spa-token');
    $token = $tokenResult->plainTextToken;

    // Gán thời gian hết hạn 12 tiếng cho token
    $latestToken = PersonalAccessToken::where('tokenable_id', $user->id)
      ->latest('id')
      ->first();

    if ($latestToken) {
      $latestToken->update(['expires_at' => now()->addHours(12)]);
    }

    return response()->json([
      "message" => "Đăng nhập thành công",
      "token" => $token,
      "user" => $user
    ], 200);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return response()->json(["message" => "Đăng xuất thành công"]);
  }
}
