<?php

namespace App\Support\Repository\Eloquent\Filterable\Clauses;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\ClausesInterface;

class OrWhereLikeClause implements ClausesInterface
{
    public function apply(object $builder, $column, $value): object
    {
        return $builder->orWhere($column, 'LIKE', "%$value%");
    }

    public static function parameter():? string
    {
        return 'orLike';
    }
}
