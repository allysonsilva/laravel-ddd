<?php

namespace App\Support\Domain;

use ReflectionClass;
use App\Core\Console\Kernel;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * List service providers to register.
     *
     * @var array
     */
    protected $subProviders;

    /**
     * List of model factories to load.
     *
     * @var array
     */
    protected $factories = [];

    /**
     * Alias for translations and views.
     *
     * @var string
     */
    protected $resourceAlias;

    /**
     * Enable views loading.
     *
     * @var bool
     */
    protected $hasViews = false;

    /**
     * Enable translations loading.
     *
     * @var bool
     */
    protected $hasTranslations = false;

    /**
     * Enable migrations loading.
     *
     * @var bool
     */
    protected $hasMigrations = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslations();
        $this->loadViews();
        $this->loadMigrations();
        $this->loadCommands();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSubProviders(collect($this->subProviders));
        $this->registerFactories(collect($this->factories));
    }

    /**
     * Register the service providers.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function registerSubProviders(Collection $subProviders)
    {
        // loop through providers to be registered
        $subProviders->each(function ($providerClass) {
            // register a provider class
            $this->app->register($providerClass);
        });
    }

    protected function registerFactories(Collection $factories)
    {
        $factories->each(function ($factoryName) {
            (new $factoryName())->define();
        });
    }

    protected function loadCommands()
    {
        (app(Kernel::class))->loadCommandsForPaths($this->resourcePath('Console'.DIRECTORY_SEPARATOR.'Commands'));

        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         FooCommand::class,
        //         BarCommand::class,
        //     ]);
        // }
    }

    protected function loadMigrations()
    {
        if ($this->hasMigrations) {
            $this->loadMigrationsFrom($this->resourcePath('Database'.DIRECTORY_SEPARATOR.'Migrations'));
        }
    }

    protected function loadTranslations()
    {
        if ($this->hasTranslations) {
            $this->loadTranslationsFrom(
                $this->resourcePath('Resources/Lang'),
                $this->resourceAlias
            );
        }
    }

    protected function loadViews()
    {
        if ($this->hasViews) {
            $this->loadViewsFrom(
                $this->resourcePath('Resources/Views'),
                $this->resourceAlias
            );
        }
    }

    protected function resourcePath(string $append): string
    {
        $reflection = new ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        return $realPath.DIRECTORY_SEPARATOR.$append;
    }
}
