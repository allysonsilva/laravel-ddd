<?php

namespace App\Support\Repository\Eloquent\Filterable\Contracts;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

interface FiltersInterface
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(object $builder, $value): object;
}
