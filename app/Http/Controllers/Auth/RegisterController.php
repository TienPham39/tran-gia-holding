<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            "user_name" => 'required|string|max:255',
            "name" => 'required|string|max:255',
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:6|confirmed",
        ], [
            // user name
            "user_name.required" => "Nhập tên tài khoản",
            "user_name.string" => "Tên tài khoản phải là chuỗi",
            "user_name.max" => "Tên tài khoản tối đa 255 ký tự",

            // name
            "name.required" => "Nhập họ & tên",
            "name.string" => "Họ & tên phải là chuỗi",
            "name.max" => "Họ & tên tối đa 255 ký tự",

            // email
            "email.required" => "Nhập email",
            "email.string" => "Email phải là chuỗi",
            "email.email" => "Email không đúng định dạng",
            "email.max" => "Email tối đa 255 ký tự",
            "email.unique" => "Email đã tồn tại",

            // password
            "password.required" => "Nhập mật khẩu",
            "password.string" => "Mật khẩu phải là chuỗi",
            "password.min" => "Mật khẩu phải có ít nhất 6 ký tự",
            "password.confirmed" => "Xác nhận mật khẩu không khớp",
        ]);

        $user = User::create([
            'user_name' => $validate['user_name'],
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'status'    => 1,       
            'roles_id'  => 2,
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => $user
        ], 200);
    }
}
