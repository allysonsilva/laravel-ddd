<?php

namespace App\Units\Auth\Providers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use App\Units\Auth\Listeners\SendVerifyEmailNotification;
use App\Units\Auth\Listeners\SendEmailSuccessfullyVerifiedNotification;
use App\Units\Auth\Listeners\SendPasswordSuccessfullyResetNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendVerifyEmailNotification::class,
        ],
        Verified::class => [
            SendEmailSuccessfullyVerifiedNotification::class,
        ],
        PasswordReset::class => [
            SendPasswordSuccessfullyResetNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
