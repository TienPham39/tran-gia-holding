<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiry
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $token = $user ? $user->currentAccessToken() : null;

        // 🔹 Nếu không có token (chưa đăng nhập) → 401
        if (!$token) {
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
        }

        // 🔹 Nếu token là TransientToken (dạng cookie / SPA) → cho qua
        if ($token instanceof \Laravel\Sanctum\TransientToken) {
            return $next($request);
        }

        // 🔹 Nếu token có expires_at và đã hết hạn
        if ($token->expires_at && $token->expires_at->isPast()) {
            $token->delete(); // xoá token hết hạn
            return response()->json(['message' => 'Phiên đăng nhập đã hết hạn'], 401);
        }

        // 🔹 Nếu token hợp lệ
        return $next($request);
    }
}
