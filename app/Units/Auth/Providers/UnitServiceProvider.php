<?php

namespace App\Units\Auth\Providers;

use App\Units\Auth\Http\Middleware\CheckRole;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Units\Auth\Http\Middleware\ApiAuthenticate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class UnitServiceProvider extends LaravelServiceProvider
{
    /**
     * Additional web middleware to register for the environment.
     *
     * @var array
     */
    private $middlewares = [
        'auth.api' => ApiAuthenticate::class,
        'role' => CheckRole::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'auth');

        $this->registerAdditionalMiddleware($this->middlewares);

        // VerifyEmail::toMailUsing(new \App\Units\Auth\Notifications\VerifyEmailNotificationToMail());
        // ResetPassword::toMailUsing(new \App\Units\Auth\Notifications\ResetPasswordNotificationToMail());
    }

    /**
     * Register additional middleware.
     *
     * @param array $middlewares
     */
    private function registerAdditionalMiddleware(array $middlewares)
    {
        foreach ($middlewares as $routeName => $middleware) {
            if (class_exists($middleware, true)) {
                // $this->app->router->pushMiddlewareToGroup('web', $middleware);
                $this->app['router']->aliasMiddleware($routeName, $middleware);
            }
        }
    }
}
