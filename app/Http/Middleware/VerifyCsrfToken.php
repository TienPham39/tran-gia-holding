<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'logout',
        'user/*',
        'contacts/*',
    ];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // ✅ Laravel tự động check token từ:
        // 1. Header: X-CSRF-TOKEN hoặc X-XSRF-TOKEN
        // 2. Input: _token
        // 3. Cookie: XSRF-TOKEN (nếu dùng Sanctum)
        $token = $this->getTokenFromRequest($request);
        $sessionToken = $request->session()->token();

        $match = hash_equals($request->session()->token(), $token);

        // Log khi token không khớp để debug
        if (!$match) {
            Log::warning('CSRF Token Mismatch', [
                'session_id' => $request->session()->getId(),
                'session_token' => $sessionToken,
                'request_token' => $token,
                'header_x_csrf' => $request->header('X-CSRF-TOKEN'),
                'header_x_xsrf' => $request->header('X-XSRF-TOKEN'),
                'input_token' => $request->input('_token'),
                'cookie_xsrf' => $request->cookie('XSRF-TOKEN'),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $match;
    }
}
