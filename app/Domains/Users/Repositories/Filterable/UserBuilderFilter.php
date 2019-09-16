<?php

namespace App\Domains\Users\Repositories\Filterable;

use Closure;
use App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter;

class UserBuilderFilter extends QueryBuilderFilter
{
    protected $custom = [
        'name_or_email',
    ];

    protected function bootBuilderFilter(): void
    {
        //
    }

    protected function accepted(): array
    {
        return [
            //! Always required key and value even if same value
            'name' => 'name',
            'status' => 'is_enabled',
            'role' => [
                'column' => 'users.role_id',
                // 'clause' => 'or',
            ],
        ];
    }

    protected function setToOrderBy(): Closure
    {
        return function(): void {
            $this->setSorting([
                'name' => 'users.name',
                'email' => 'users.email',
                'status' => 'is_enabled',
                'role' => 'role_level',
                //! Always required key and value even if same value
                'last_login_at' => 'last_login_at',
            ]);
        };
    }

    protected function setToSortBy(): Closure
    {
        return $this->setToOrderBy();
    }

    protected function setToGroupBy(): Closure
    {
        return function(): void {
            $this->setGroup([
                // 'name' => 'users.name',
            ]);
        };
    }

    protected function filterByNameOrEmail(object &$query, string $value): object
    {
        $query->where(function($innerQuery) use ($value) {
            $innerQuery->where('users.email', 'LIKE', "%{$value}%")
                       ->orWhere('users.name', 'LIKE', "%{$value}%");
        });

        return $query;
    }
}
