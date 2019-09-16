<?php

namespace App\Support\Repository\Eloquent\Filterable\Contracts;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

interface ClausesInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $column
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(object $builder, $column, $value): object;

    /**
     * Parameter used as value in {$fieldsFilterable} variable.
     *
     * @return string|null
     */
    public static function parameter():? string;
}
