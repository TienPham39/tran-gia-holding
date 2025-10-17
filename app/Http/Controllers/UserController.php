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

    public function changePassword(Request $request)
    {
        $request->validate([
            // 'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            // 'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại !',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới !',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự !',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        // if (!\Hash::check($request->current_password, $user->password)) {
        //     return response()->json([
        //         'message' => 'Mật khẩu hiện tại không đúng!',
        //     ], 422);
        // }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => \Hash::make($request->new_password),
            'change_password_at' => now(),
        ]);

        return response()->json([
            'message' => 'Cập nhật mật khẩu thành công!',
        ], 200);
    }

    public function updateProfile(request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'user_name.required' => 'Vui lòng nhập tên tài khoản',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh',
            'avatar.max' => 'Ảnh không được vượt quá 2MB',
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $filename, 'public');
            $validated['avatar'] = '/storage/' . $path;
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Cập nhật hồ sơ thành công!',
            'user' => $user->fresh(),
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed'
        ], [
            "new_password.required" => "Nhập password mới",
            "new_password.confirmed" => "Mật khẩu xác nhận không khớp",
            "new_password.min" => "Mật khẩu mới tối thiểu 6 ký tự",
        ]);
        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['message' => 'Đặt mật khẩu mới thành công!']);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'Vui lòng nhập mật khẩu mới!',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự!',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp!',
        ]);

        $user = $request->user();

        // Nếu user không phải đăng nhập bằng Google thì không cho set password
        if ($user->provider !== 'google') {
            return response()->json([
                'message' => 'Chỉ người dùng đăng nhập bằng Google mới có thể đặt mật khẩu theo cách này.',
            ], 403);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => \Hash::make($request->new_password),
            'change_password_at' => now(),
        ]);

        return response()->json([
            'message' => 'Đặt mật khẩu mới thành công!',
            'user' => $user,
        ], 200);
    }
}
