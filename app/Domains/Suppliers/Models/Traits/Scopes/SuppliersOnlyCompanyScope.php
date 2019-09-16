<?php

namespace App\Domains\Suppliers\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SuppliersOnlyCompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (! empty($company = session('company')) || auth()->user()->isCompany()) {
            return $builder->whereUserId(auth()->id());
        }
    }
}
