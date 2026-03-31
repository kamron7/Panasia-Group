<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $locales = ['ru', 'oz', 'en'];

            foreach ($locales as $locale) {
                Route::prefix($locale)
                    ->middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/public.php'));
            }

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/public.php'));
        });
    }
}
