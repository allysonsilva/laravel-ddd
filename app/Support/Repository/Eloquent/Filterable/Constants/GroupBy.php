<?php

namespace App\Support\Repository\Eloquent\Filterable\Constants;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Support\Repository\Eloquent\Filterable\Contracts\FiltersInterface;

/**
 * @example
 *
 * ?group_by=name,email
 */
class GroupBy implements FiltersInterface
{
    /** @var \Illuminate\Database\Eloquent\Builder */
    private $builder;

    protected $group = [];

    public function apply(object $builder, $value): object
    {
        $this->builder = $builder;

        array_map([$this, 'appendGroupBy'], array_filter(explode(',', $value)));

        return $this->builder;
    }

    private function appendGroupBy(string $column): void
    {
        if (! array_key_exists($column, $this->group)) {
            return;
        }

        $this->builder = $this->builder->groupBy(DB::raw($this->group[$column]));
    }

    public function setGroup(array $group): void
    {
        $this->group = $group;
    }
}
