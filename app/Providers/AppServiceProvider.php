<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Saat online (mis. Vercel) aplikasi berada di belakang proxy HTTPS:
        // paksa semua link memakai https agar CSS/JS tidak diblokir browser.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
