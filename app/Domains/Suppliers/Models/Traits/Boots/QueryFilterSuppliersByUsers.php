<?php

namespace App\Domains\Suppliers\Models\Traits\Boots;

use App\Domains\Suppliers\Models\Traits\Scopes\SuppliersOnlyCompanyScope;

trait QueryFilterSuppliersByUsers {

    public static function bootQueryFilterSuppliersByUsers()
    {
        if (auth()->check()) {
            static::addGlobalScope(new SuppliersOnlyCompanyScope);
        }
    }
}
