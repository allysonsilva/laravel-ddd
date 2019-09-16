<?php

namespace App\Support;

use App\Support\View\ViewServiceProvider;
use App\Support\Queue\HorizonServiceProvider;
use Illuminate\Support\AggregateServiceProvider;
use App\Support\Database\ConsoleSupportServiceProvider;
use App\Support\Queue\HorizonApplicationServiceProvider;
use App\Support\Localization\LocalizationServiceProvider;

class SupportServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ConsoleSupportServiceProvider::class,
        ViewServiceProvider::class,
        // HorizonServiceProvider::class,
        // HorizonApplicationServiceProvider::class,
        LocalizationServiceProvider::class,
    ];
}
