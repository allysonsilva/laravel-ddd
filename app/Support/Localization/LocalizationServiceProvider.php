<?php

namespace App\Support\Localization;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

        Carbon::setLocale(app()->getLocale());
    }
}
