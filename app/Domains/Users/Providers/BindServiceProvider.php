<?php

namespace App\Domains\Users\Providers;

use App\Domains\Users\Services;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\ServiceProvider;
use App\Domains\Users\Services\Contracts as ServicesContracts;

class BindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // $this->loadCommands();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerServices();
        $this->registerMiddlewares();
        $this->registerFactories();
    }

    /**
     * Load any commands services.
     *
     * @return void
     */
    private function loadCommands(): void
    {
        // $path = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Console'.DIRECTORY_SEPARATOR.'Commands');

        // $commandsPath = [];
        // /** @var $file \Symfony\Component\Finder\SplFileInfo */
        // foreach ((Finder::create()->files()->name('*.php')->in($path)->exclude('Off')) as $splFileInfo) {
        //     $commandsPath[] = (\App\Domains\Users\Console\Commands::class)."\\{$splFileInfo->getFilenameWithoutExtension()}";
        // }

        // $this->commands($commandsPath);
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    private function registerFactories(): void
    {
        // if (! app()->environment('production')) {
        //     app(Factory::class)->load(__DIR__ . '/../Database/factories');
        // }
    }

    /**
     * Register any middlewares services.
     *
     * @return void
     */
    private function registerMiddlewares(): void
    {
        // $this->app->router->aliasMiddleware('permissionAdmin', \App\Domains\Users\Http\Middleware\PermissionAdmin::class);
    }

    /**
     * Register any repositories services.
     *
     * @return void
     */
    public function registerRepositories(): void
    {
        // $this->app->bind(
        //     Contracts\PermissionRepository::class,
        //     Repositories\PermissionRepository::class
        // );

        // $this->app->bind(
        //     Contracts\RoleRepository::class,
        //     Repositories\RoleRepository::class
        // );
    }

    /**
     * Register any domain services.
     *
     * @return void
     */
    public function registerServices(): void
    {
        //
    }
}
