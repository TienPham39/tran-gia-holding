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
    public function handle(Request $request, Closure $next)
    {
        // Lấy token hiện tại của user (nếu có)
        $token = $request->user()?->currentAccessToken();

        // Nếu có token và token có expires_at
        if ($token && $token->expires_at) {
            $expiresAt = Carbon::parse($token->expires_at);

            // Nếu token đã hết hạn
            if ($expiresAt->isPast()) {

                // Xóa token khỏi DB nếu vẫn tồn tại
                $realToken = PersonalAccessToken::find($token->id);
                if ($realToken) {
                    $realToken->delete();
                }

                return response()->json([
                    'status' => 'expired',
                    'message' => 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.'
                ], 401);
            }
        }

        // Nếu không có token hoặc token hợp lệ → tiếp tục request
        return $next($request);
    }
}

