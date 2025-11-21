<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\AdminMiddleware;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Router $router): void
    {
        // Register admin middleware
        $router->aliasMiddleware('admin', AdminMiddleware::class);

        // === CORRECT WAY TO LOAD API ROUTES IN LARAVEL 11 ===
        \Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Web routes (already working)
        \Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
