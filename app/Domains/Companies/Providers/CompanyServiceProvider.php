<?php

namespace App\Domains\Companies\Providers;

use App\Domains\Companies\Database\Factories\CompanyFactory;
use App\Support\Domain\ServiceProvider as DomainServiceProvider;

class CompanyServiceProvider extends DomainServiceProvider
{
    protected $resourceAlias = 'companies';

    protected $hasViews = true;

    protected $hasTranslations = true;

    protected $hasMigrations = true;

    protected $factories = [
        CompanyFactory::class,
    ];

    protected $subProviders = [
        RouteServiceProvider::class,
        AuthServiceProvider::class,
    ];
}
