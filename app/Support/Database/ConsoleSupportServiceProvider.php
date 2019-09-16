<?php

namespace App\Support\Database;

use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Support\Database\Console\ArtisanServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider implements DeferrableProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
    ];
}
