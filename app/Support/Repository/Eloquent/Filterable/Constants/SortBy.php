<?php

namespace App\Support\Repository\Eloquent\Filterable\Constants;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\FiltersInterface;

class SortBy implements FiltersInterface
{
    protected $sorting = [];

    /**
     * Apply a given search value to the builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(object $builder, $column): object
    {
        if (! array_key_exists($column, $this->sorting)) {
            return $builder;
        }

        $withSortBy = $builder->orderBy(DB::raw($this->sorting[$column]), request('sort_order') ?? 'DESC');

        return $withSortBy;
    }

    public function setSorting(array $sorting): void
    {
        $this->sorting = $sorting;
    }
}
