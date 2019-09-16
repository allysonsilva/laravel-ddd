<?php

namespace App\Support\Repository\Eloquent\Filterable\Constants;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\FiltersInterface;

/**
 * @example
 *
 * ?limit=102030
 */
class Limit implements FiltersInterface
{
    public function apply(object $builder, $value): object
    {
        $withLimit =& $builder->limit((int) $value);

        $withLimit->getModel()->setPerPage((int) $value);

        return $withLimit;
    }
}
