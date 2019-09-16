<?php

namespace App\Domains\Suppliers\Providers;

use App\Domains\Suppliers\Database\Factories\SupplierFactory;
use App\Support\Domain\ServiceProvider as DomainServiceProvider;

class SupplierServiceProvider extends DomainServiceProvider
{
    protected $resourceAlias = 'suppliers';

    protected $hasViews = true;

    protected $hasTranslations = true;

    protected $hasMigrations = true;

    protected $factories = [
        SupplierFactory::class,
    ];

    protected $subProviders = [
        RouteServiceProvider::class,
        AuthServiceProvider::class,
    ];
}
