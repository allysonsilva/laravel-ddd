<?php

namespace App\Support\Queue;

use Laravel\Horizon\HorizonServiceProvider as BaseHorizonServiceProvider;

class HorizonServiceProvider extends BaseHorizonServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
