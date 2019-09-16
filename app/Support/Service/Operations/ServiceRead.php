<?php

namespace App\Support\Service\Operations;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter;

trait ServiceRead
{
    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $columns = ['*']): Collection
    {
        return $this->repository->get($columns);
    }

    /**
     * Find multiple models by their primary keys.
     *
     * @param \Illuminate\Contracts\Support\Arrayable|array|int $ids
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($ids, array $columns = ['*'])
    {
        return $this->repository->find($ids, $columns);
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param \App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter|null $queryBuilderFilter
     * @param  string  $method
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Contracts\Pagination\Paginator|array
     */
    public function paginate(?QueryBuilderFilter $queryBuilderFilter, string $method = 'paginate'): array
    {
        return $this->repository->{$method}($queryBuilderFilter);
    }
}
