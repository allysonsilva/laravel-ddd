<?php

namespace App\Domains\Users\Services;

use Throwable;
use Illuminate\Support\Facades\DB;
use App\Support\Service\BaseService;
use App\Domains\Users\Repositories\UserRepository;
use App\Domains\Users\Repositories\Criteria\JoinRoleCriteria;
use App\Domains\Users\Repositories\Filterable\UserBuilderFilter;
use App\Domains\Users\Repositories\Criteria\UserPermissionCriteria;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Lista todos os usuários aplicando determinados filtros de Criteria.
     *
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function listAllFilteredUsers(): array
    {
        DB::beginTransaction();

        try {

            $this->repository->pushCriteria(JoinRoleCriteria::class);
            $this->repository->pushCriteria(UserPermissionCriteria::class);

            return [$users, $perPage] = $this->repository->paginate(app(UserBuilderFilter::class));

        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }
}
