<?php

namespace App\Domains\Users\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Support\Repository\Eloquent\Contracts\CriterionInterface;
use App\Support\Repository\Eloquent\Contracts\RepositoryInterface;

class UserPermissionCriteria implements CriterionInterface
{
    /**
     * Applies the given where conditions to the model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \App\Support\Repository\Eloquent\Contracts\RepositoryInterface $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(object &$builder, RepositoryInterface $repository): object
    {
        if (auth()->user()->roleIs('admin')) {
            return $builder->whereNotIn('roles.code', ['super-admin']);
        }

        return $builder;
    }
}
