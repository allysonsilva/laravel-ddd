<?php

namespace App\Support\Repository\Eloquent\Operations;

use ReflectionClass;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Support\Repository\Eloquent\Criteria\FindWhere;
use App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter;

trait RepositoryRead
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|null
     */
    public function find($id, array $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->entity->find($id, $columns);

        $this->reset();

        return $result;
    }

    /**
     * Execute the query and get the first result.
     *
     * @param  array  $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|object|null
     */
    public function first(array $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->entity->first($columns);

        $this->reset();

        return $result;
    }

    /**
     * Find data by multiple fields.
     *
     * Add basic where clauses and execute the query.
     *
     * @param array $where
     * @param array $columns
     *
     * @example
     *  $posts = $this->repository->findWhere([
     *      //Default Condition =
     *      'category_id' => '2',
     *      'user_id' => '1',
     *      //Custom Condition
     *      ['column_name', '>', '10']
     *  ]);
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhere(array $where, array $columns = ['*']): Collection
    {
        return $this->withCriteria(app(FindWhere::class, ['conditions' => $where]))->get($columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, array $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->entity->findOrFail($id, $columns);

        $this->reset();

        return $result;
    }

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param  array  $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function firstOrFail(array $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->entity->firstOrFail($columns);

        $this->reset();

        return $result;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param array|mixed $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $columns = ['*']): Collection
    {
        $this->applyCriteria();

        $results = $this->cacheHandle(__FUNCTION__, function() use ($columns) {
            return $this->entity->get($columns);
        });

        $this->reset();

        return $results;
    }

    /**
     * Retrieve all data of repository, paginated.
     *
     * Paginate the given query.
     *
     * @param \App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter|null $queryBuilderFilter
     * @param int $perPage
     * @param array $columns
     * @param string $method
     *
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractPaginator
     */
    public function paginate(?QueryBuilderFilter $queryBuilderFilter, int $perPage = null, array $columns = ['*'], string $method = 'paginate'): array
    {
        $this->applyCriteria();

        if (! is_null($queryBuilderFilter))
            $this->entity = $queryBuilderFilter->build($this->entity, (app(ReflectionClass::class, ['argument' => $this]))->getNamespaceName());

        $perPage = $perPage ?: $this->entity->getModel()->getPerPage();

        $results = $this->entity->{$method}($perPage, $columns)->onEachSide(1);

        $this->reset();

        return [$results, $perPage];
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param \App\Support\Repository\Eloquent\Filterable\QueryBuilderFilter|null $queryBuilderFilter
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $currentPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\Paginator
     */
    public function simplePaginate(?QueryBuilderFilter $queryBuilderFilter, $perPage = null, array $columns = ['*'], $pageName = 'page', $currentPage = null): array
    {
        $this->applyCriteria();

        if (! is_null($queryBuilderFilter))
            $this->entity = $queryBuilderFilter->build($this->entity, (app(ReflectionClass::class, ['argument' => $this]))->getNamespaceName());

        $currentPage = $currentPage ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->entity->getModel()->getPerPage();

        // Next we will set the limit and offset for this query so that when we get the
        // results we get the proper section of results. Then, we'll create the full
        // paginator instances for these results with the given page and per page.
        $this->entity->skip(($currentPage - 1) * $perPage)->take($perPage + 1);

        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ];

        $results = $this->cacheHandle(__FUNCTION__, function() use ($perPage, $columns, $currentPage, $options) {
            $items = $this->entity->get($columns);

            return app(Paginator::class, compact(
                'items', 'perPage', 'currentPage', 'options'
            ));
        });

        $this->reset();

        return [$results, $perPage];
    }
}
