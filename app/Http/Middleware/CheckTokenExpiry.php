<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token missing'], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || $accessToken->expires_at && Carbon::now()->gt($accessToken->expires_at)) {
            if ($accessToken)
                $accessToken->delete();
            return response()->json(['message' => 'Token expired or invalid'], 401);
        }

        return $next($request);
    }
}

