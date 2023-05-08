<?php

namespace App\Providers;

use App\Foundation\Routing\Concerns\MapsRouteRegistrars;
use App\Foundation\Routing\Registrars\DefaultRegistrar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    use MapsRouteRegistrars;

    protected array $registrars = [
        DefaultRegistrar::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->routes(function (Registrar $router) {
            $this->mapRoutes($router, $this->registrars);

            Route::prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::prefix('general')
                ->group(base_path('routes/general.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
