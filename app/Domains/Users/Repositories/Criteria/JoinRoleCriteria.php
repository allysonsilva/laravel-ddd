<?php

namespace App\Domains\Users\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use App\Support\Repository\Eloquent\Contracts\CriterionInterface;
use App\Support\Repository\Eloquent\Contracts\RepositoryInterface;

class JoinRoleCriteria implements CriterionInterface
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
        return
            $builder
                ->selectRaw(
                    <<<QUERY
                        users.*,
                        roles.level as role_level,
                        roles.code as role_code
                    QUERY
                )
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->with('role');
    }
}
