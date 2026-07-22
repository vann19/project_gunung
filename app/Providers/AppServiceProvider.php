<?php

namespace App\Providers;

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
        // Push visit-logging middleware into the web group so regular page views are recorded
        if ($this->app->bound('router')) {
            $this->app['router']->pushMiddlewareToGroup('web', \App\Http\Middleware\LogVisit::class);
        }
    }
}
