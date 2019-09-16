<?php

namespace App\Domains\Users\Providers;

use App\Domains\Users\Database\Factories\UserFactory;
use App\Domains\Users\Database\Factories\UserAdminRoleFactory;
use App\Domains\Users\Database\Factories\UserCompanyRoleFactory;
use App\Support\Domain\ServiceProvider as DomainServiceProvider;
use App\Domains\Users\Database\Factories\UserSuperAdminRoleFactory;

class UserServiceProvider extends DomainServiceProvider
{
    protected $resourceAlias = 'users';

    protected $hasViews = true;

    protected $hasTranslations = true;

    protected $hasMigrations = true;

    protected $factories = [
        UserFactory::class,
        UserAdminRoleFactory::class,
        UserCompanyRoleFactory::class,
        UserSuperAdminRoleFactory::class,
    ];

    protected $subProviders = [
        BindServiceProvider::class,
        RouteServiceProvider::class,
        EventServiceProvider::class,
        AuthServiceProvider::class,
    ];
}
