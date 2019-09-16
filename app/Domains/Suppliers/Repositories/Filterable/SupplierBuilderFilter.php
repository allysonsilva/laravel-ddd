<?php

namespace App\Domains\Suppliers\Repositories\Filterable;

use Closure;
use App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter;

class SupplierBuilderFilter extends QueryBuilderFilter
{
    protected function accepted(): array
    {
        return [
            'name' => [
                // 'column' => 'name',
                'clause' => 'like'
            ],
            'email' => [
                'column' => 'suppliers.email',
                'clause' => 'like'
            ],
            'status' => 'is_activated',
        ];
    }

    protected function setToOrderBy(): Closure
    {
        return function(): void {
            $this->setSorting([
                'name' => 'suppliers.name',
                'email' => 'suppliers.email',
                'status' => 'suppliers.is_activated',
                //! Always required key and value even if same value
                'activated_at' => 'activated_at',
            ]);
        };
    }

    protected function setToSortBy(): Closure
    {
        return $this->setToOrderBy();
    }
}
