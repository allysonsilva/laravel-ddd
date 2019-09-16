<?php

namespace App\Units\Dashboard\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class UnitServiceProvider extends LaravelServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'dashboard');
    }
}
