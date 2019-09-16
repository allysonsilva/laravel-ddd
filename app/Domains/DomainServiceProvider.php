<?php

namespace App\Domains;

use Illuminate\Support\AggregateServiceProvider;
use App\Domains\Users\Providers\UserServiceProvider;
use App\Domains\Companies\Providers\CompanyServiceProvider;
use App\Domains\Suppliers\Providers\SupplierServiceProvider;

class DomainServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        UserServiceProvider::class,
        SupplierServiceProvider::class,
        CompanyServiceProvider::class,
    ];
}
