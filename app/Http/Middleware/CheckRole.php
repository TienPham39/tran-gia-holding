<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles  // các role được truyền vào middleware
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
            
        }

        // Nếu user.roles_id không nằm trong danh sách roles cho phép
        if (!in_array($user->roles_id, $roles)) {
            return response()->json(['message' => 'Bạn không có quyền truy cập'], 403);
        }

        return $next($request);
    }
}
