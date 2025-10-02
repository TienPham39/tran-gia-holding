<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $validate = $request->validate([
      "email" => "required|email",
      "password" => "required|string|min:6",
    ], [
      // email
      "email.required" => "Vui lòng nhập email",
      "email.email" => "Email không đúng định dạng",

      // password
      "password.required" => "Vui lòng nhập mật khẩu",
      "password.string" => "Mật khẩu phải là chuỗi ký tự",
      "password.min" => "Mật khẩu phải có ít nhất 6 ký tự",
    ]);

    if (!Auth::attempt($validate)) {
      return response()->json([
        "message" => "Sai email hoặc mật khẩu"
      ], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('spa-token')->plainTextToken;

    return response()->json([
      "message" => "Đăng nhập thành công",
      "token" => $token,
      "user" => $user
    ], 200);
  }

  public function user(Request $request)
  {
    return $request->user();
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return response()->json(["message" => "Đăng xuất thành công"]);
  }
}
