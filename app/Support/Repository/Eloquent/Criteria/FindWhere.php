<?php

namespace App\Support\Repository\Eloquent\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Support\Repository\Eloquent\Contracts\CriterionInterface;
use App\Support\Repository\Eloquent\Contracts\RepositoryInterface;

class FindWhere implements CriterionInterface
{
    protected $conditions;

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \App\Support\Repository\Eloquent\Contracts\RepositoryInterface $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(object $builder, RepositoryInterface $repository): Builder
    {
        foreach ($this->conditions as $field => $value) {
            if (is_array($value)) {
                [$field, $condition, $value] = $value;
                $builder = $builder->where($field, $condition, $value);
            } else {
                $builder = $builder->where($field, $value);
            }
        }

        return $builder;
    }
}
