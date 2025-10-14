<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;


class UserController extends Controller
{
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function index()
    {
        $users = User::where("users.id", "!=", "2")
            ->join('roles', 'users.roles_id', '=', 'roles.id')  // join bảng roles
            ->select('users.*', 'roles.name as role')  // Lấy thêm thông tin role
            ->paginate(5);  // Phân trang với 5 bản ghi mỗi trang

        return response()->json([
            'data' => $users->items(),  // Dữ liệu người dùng
            'total' => $users->total(),  // Tổng số người dùng
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
            'last_page' => $users->lastPage(),
        ]);
    }

    public function create()
    {
        $roles = DB::table('roles')
            ->select('id as value', 'name as label')
            ->get();

        return response()->json([
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        // Validate and store the blog post...
        $validated = $request->validate([
            "user_name" => "required|unique:users,user_name,",
            "name" => "required",
            "email" => "required|email|unique:users,email,",
            "password" => "required|confirmed|min:6",
            "roles_id" => "required|exists:roles,id",
        ], [
            "user_name.required" => "Nhập tên tài khoản",
            "user_name.unique" => "Tên tài khoản đã tồn tại",
            "name.required" => "Nhập họ & tên",
            "email.required" => "Nhập email",
            "email.email" => "Email không đúng định dạng",
            "email.unique" => "Email đã tồn tại",
            "password.required" => "Nhập password",
            "password.confirmed" => "Mật khẩu xác nhận không khớp",
            "password.min" => "Mật khẩu tối thiểu 6 ký tự",
            "roles_id.required" => "Chọn vai trò",
            "roles_id.exists" => "Vai trò không hợp lệ",
        ]);

        $data = [
            "user_name" => $validated['user_name'],
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
            "status" => $request["status"] ?? 'active',
            "roles_id" => $validated["roles_id"],
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $filename, 'public');
            $data['avatar'] = '/storage/' . $path;
        }

        $user = User::create($data);

        return response()->json([
            'message' => 'Tạo người dùng thành công',
            'user' => $user,
        ], 200);
    }

    public function edit($id)
    {
        $users = User::find($id);
        $roles = DB::table('roles')
            ->select('id as value', 'name as label')
            ->get();
        return response()->json([
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate and store the blog post...
        $validated = $request->validate([
            "user_name" => "required",
            "name" => "required",
            "email" => "required|email|unique:users,email," . $id,
            "roles_id" => "required|exists:roles,id",
        ], [
            "user_name.required" => "Nhập tên tài khoản",
            "name.required" => "Nhập họ & tên",

            "email.required" => "Nhập email",
            "email.email" => "Email không đúng định dạng",
            "email.unique" => "Email đã tồn tại",

            "roles_id.required" => "Chọn vai trò",
            "roles_id.exists" => "Vai trò không hợp lệ",
        ]);

        $user = User::findOrFail($id);

        $data = [
            "user_name" => $validated["user_name"],
            "name" => $validated["name"],
            "email" => $validated["email"],
            "roles_id" => $validated["roles_id"],
            "status" => $request->status ?? $user->status,
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $filename, 'public');
            $data['avatar'] = '/storage/' . $path;
        }

        if ($request->change_password) {
            $validated = $request->validate([
                "password" => "required|confirmed|min:6",
            ], [
                "password.required" => "Nhập password",
                "password.confirmed" => "Mật khẩu xác nhận không khớp",
                "password.min" => "Mật khẩu tối thiểu 6 ký tự",
            ]);

            $data["password"] = Hash::make($validated["password"]);
            $data["change_password_at"] = now();
        }

        $user->update($data);

        UserActivity::create([
            'user_id' => auth()->id() ?? $user->id,
            'action' => 'update_profile',
            'description' => 'Cập nhật thông tin hồ sơ cá nhân',
        ]);

        if ($request->change_password) {
            UserActivity::create([
                'user_id' => auth()->id() ?? $user->id,
                'action' => 'change_password',
                'description' => 'Thay đổi mật khẩu tài khoản',
            ]);
        }

        return response()->json([
            'message' => 'Cập nhật thành công',
            'user' => $user,
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (Auth::id() == $id) {
            return response()->json([
                'message' => 'Không thể xóa tài khoản của chính bạn'
            ], 403);
        }

        if (!$user) {
            return response()->json([
                'message' => 'Người dùng không tồn tại'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Xóa người dùng thành công'
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ], [
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ'
        ]);

        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Cập nhật trạng thái người dùng thành công',
            'user' => $user,
        ], 200);
    }
}
