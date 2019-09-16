<?php

namespace App\Core\Providers;

use PDO;
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
        // $this->registerHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->url->forceScheme('https');

        if ($this->app->environment('production')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE);
        }

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

    public function registerHelpers()
    {
        foreach (glob(app_path('Support/Helpers').DIRECTORY_SEPARATOR.'*.php') as $filename) {
            require_once $filename;
        }
    }
}
