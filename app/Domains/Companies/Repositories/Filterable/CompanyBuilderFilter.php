<?php

namespace App\Domains\Companies\Repositories\Filterable;

use Closure;
use App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter;

class CompanyBuilderFilter extends QueryBuilderFilter
{
    protected $custom = [
        'user_name_or_email',
        'social_or_fantasy',
    ];

    protected function accepted(): array
    {
        return [
            'cnpj' => 'companies.cnpj',
        ];
    }

    protected function setToOrderBy(): Closure
    {
        return function(): void {
            $this->setSorting([
                'social_name' => 'companies.social_name',
                'fantasy_name' => 'companies.fantasy_name',
                //! Always required key and value even if same value
                'cnpj' => 'cnpj',
            ]);
        };
    }

    protected function setToSortBy(): Closure
    {
        return $this->setToOrderBy();
    }

    protected function filterByUserNameOrEmail(object &$query, string $value): object
    {
        $query->where(function($innerQuery) use ($value) {
            $innerQuery->where('users.email', 'LIKE', "%{$value}%")
                       ->orWhere('users.name', 'LIKE', "%{$value}%");
        });

        return $query;
    }

    protected function filterBySocialOrFantasy(object &$query, string $value): object
    {
        $query->where(function($innerQuery) use ($value) {
            $innerQuery->where('companies.social_name', 'LIKE', "%{$value}%")
                       ->orWhere('companies.fantasy_name', 'LIKE', "%{$value}%");
        });

        return $query;
    }
}
