<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Boot services.
     */
    public function boot(): void
    {
        // Chia sẻ user cho toàn bộ Inertia
        Inertia::share('auth.user', function () {
            return Auth::user() ? Auth::user()->load('role') : null;
        });
        Inertia::share([
            'tinymce_api_key' => env('TINYMCE_API_KEY'),
        ]);

        // Định nghĩa route (nếu bạn thật sự cần trong provider này)
        $this->routes(function () {
            // API routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Web routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
