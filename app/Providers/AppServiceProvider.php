<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
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
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        Carbon::setLocale('pt_BR');

        Blade::component('layouts.partials.head', 'head');
        Blade::component('layouts.partials.footer', 'footer');
        Blade::component('layouts.partials.scripts', 'scripts');
        Blade::component('layouts.partials.left', 'leftSidebar');
        Blade::component('layouts.partials.navigation', 'navigation');
        Blade::component('layouts.partials.notifications', 'notifications');

        $this->loadViewsFrom(resource_path('views/pages'), 'pages');
        $this->loadViewsFrom(resource_path('views/errors'), 'errors');
        $this->loadViewsFrom(resource_path('views/modules'), 'modules');
        $this->loadViewsFrom(resource_path('views/layouts'), 'layouts');
    }
}
