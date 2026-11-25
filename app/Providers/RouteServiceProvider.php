<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Penghitung terpisah per fitur, agar percobaan "lupa password" tidak ikut
        // mengunci halaman login (throttle:x,y biasa memakai satu penghitung per IP).
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by('login|'.$request->ip()));
        RateLimiter::for('lupa-password', fn (Request $request) => [
            Limit::perMinute(3)->by('lupa|'.$request->ip()),
            Limit::perHour(10)->by('lupa-email|'.mb_strtolower((string) $request->input('email'))),
        ]);
        RateLimiter::for('daftar', fn (Request $request) => [Limit::perMinute(5)->by('daftar|'.$request->ip()), Limit::perHour(20)->by('daftar-jam|'.$request->ip())]);
        RateLimiter::for('reset-password', fn (Request $request) => Limit::perMinute(5)->by('reset|'.$request->ip()));
    }
}
