<?php

namespace App\Providers;

use PDO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailServiceProvider;

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

        $this->app->url->forceScheme('https');

        if (version_compare(phpversion(), '5.3.7', '>')) {
            config(['database.connections.mysql.options' => [
                PDO::MYSQL_ATTR_SSL_KEY => database_path('docker/mysql/ssl/client-key.pem'),
                PDO::MYSQL_ATTR_SSL_CERT => database_path('docker/mysql/ssl/client-cert.pem'),
                PDO::MYSQL_ATTR_SSL_CA => database_path( 'docker/mysql/ssl/ca.pem'),
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
            ]]);
        }

        if ($this->app->environment('local', 'development', 'staging')) {
            config(['mail.to' => [
                'address' => env('MAIL_DEVELOPMENT_ADDRESS'),
                'name' => env('MAIL_DEVELOPMENT_NAME'),
            ]]);

            (new MailServiceProvider(app()))->register();
        }
    }
}
