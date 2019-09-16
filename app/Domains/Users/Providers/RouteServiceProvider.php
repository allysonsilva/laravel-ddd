<?php

namespace App\Domains\Users\Providers;

use Illuminate\Support\Facades\Route;
use App\Domains\Users\Console\Closures\ClosureCommands;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected const __DOMAIN = 'Users';

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = \App\Domains\Users\Http\Controllers::class;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('douser', '[0-9]+');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // $this->app->router->model('douser', \App\Domains\Users\Models\User::class);

        $this->mapWebRoutes();

        $this->mapApiRoutes();

        $this->mapConsoleRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'auth:web'])
              ->namespace($this->namespace)
              ->group(domain_route_file(self::__DOMAIN, 'Web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix(api_prefix(null))
             ->name('api.')
             ->middleware(['api', 'auth.api', 'verified'])
             ->namespace($this->namespace)
             ->group(domain_route_file(self::__DOMAIN, 'Api.php'));
    }

    /**
     * Define the "console" routes for the application.
     *
     * Those routes are the ones defined by artisan->command
     * instead of registered directly on the Console\Kernel.
     */
    protected function mapConsoleRoutes()
    {
        (new ClosureCommands())->registerCommands();
    }
}
