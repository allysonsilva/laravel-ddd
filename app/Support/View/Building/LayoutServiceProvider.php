<?php

namespace App\Support\View\Building;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('layouts.partials.head', 'head');
        Blade::component('layouts.partials.left', 'left');
        Blade::component('layouts.partials.footer', 'footer');
        Blade::component('layouts.partials.scripts', 'scripts');
        Blade::component('layouts.partials.navigation', 'navigation');
        Blade::component('layouts.partials.notifications', 'notifications');

        $this->loadViewsFrom(resource_path('views/layouts'), 'layouts');
    }
}
