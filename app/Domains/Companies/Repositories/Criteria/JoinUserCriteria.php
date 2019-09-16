<?php

namespace App\Domains\Companies\Repositories\Criteria;

use App\Support\Repository\Eloquent\Contracts\CriterionInterface;
use App\Support\Repository\Eloquent\Contracts\RepositoryInterface;

class JoinUserCriteria implements CriterionInterface
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
                        companies.*,
                        users.name as user_name,
                        users.email as user_email
                    QUERY
                )
                ->join('users', 'companies.user_id', '=', 'users.id')
                ->with('user');
    }
}
