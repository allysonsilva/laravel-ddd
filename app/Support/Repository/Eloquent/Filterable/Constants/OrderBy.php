<?php

namespace App\Support\Repository\Eloquent\Filterable\Constants;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\FiltersInterface;

/**
 * @example
 *
 * ?order_by=name,asc|email (Default $this->direction)
 */
class OrderBy implements FiltersInterface
{
    /** @var \Illuminate\Database\Eloquent\Builder */
    private $builder;

    protected $sorting = [];

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
        $this->builder =& $builder;

        array_map([$this, 'appendOrderBy'], array_filter(explode('|', $value)));

        return $this->builder;
    }

    private function appendOrderBy(string $order): void
    {
        $fieldWithSort = explode(',', $order);

        [$column, $direction] = $fieldWithSort;

        if (! array_key_exists($column, $this->sorting)) {
            return;
        }

        $this->builder = $this->builder->orderBy(DB::raw($this->sorting[$column]), $direction ?? 'DESC');
    }

    public function setSorting(array $sorting): void
    {
        $this->sorting = $sorting;
    }
}
