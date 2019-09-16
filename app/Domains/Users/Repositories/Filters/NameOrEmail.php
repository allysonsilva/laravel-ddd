<?php

namespace App\Domains\Users\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\FiltersInterface;

class NameOrEmail implements FiltersInterface
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(object $builder, $value): object
    {
        return
            $builder->where(function($query) use ($value) {
                $query->where('users.email', 'LIKE', "%{$value}%")
                    ->orWhere('users.name', 'LIKE', "%{$value}%");
            });
    }
}
