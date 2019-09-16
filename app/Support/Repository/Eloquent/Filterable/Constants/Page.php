<?php

namespace App\Support\Repository\Eloquent\Filterable\Constants;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\FiltersInterface;

/**
 * @example
 *
 * ?page=123
 */
class Page implements FiltersInterface
{
    public function apply(object $builder, $value): object
    {
        $limit = $builder->getQuery()->limit ?? $builder->getModel()->getPerPage();

        $withPage = $builder->forPage((int) $value, $limit);

        return $withPage;
    }
}
