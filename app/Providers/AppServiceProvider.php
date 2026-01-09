<?php

namespace App\Providers;

use App\Models\News;
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
            'tinymce_api_key' => config('services.tinymce.api_key'),
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
        }); {
            Inertia::share('sharedNews', function () {
                return News::latest()
                    ->select(
                        'id',
                        'title',
                        'slug',
                        'excerpt',
                        'thumbnail_base64',
                        'created_at'
                    )
                    ->take(2)
                    ->get();
            });
        }
    }
}
