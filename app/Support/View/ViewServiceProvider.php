<?php

namespace App\Support\View;

use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

use App\Support\View\Building\{
    FormServiceProvider,
    LayoutServiceProvider,
    BladeExtensionsServiceProvider
};

class ViewServiceProvider extends AggregateServiceProvider implements DeferrableProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        FormServiceProvider::class,
        LayoutServiceProvider::class,
        BladeExtensionsServiceProvider::class,
    ];
}
