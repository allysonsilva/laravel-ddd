<?php

namespace App\Domains\Companies\Services;

use Throwable;
use Illuminate\Support\Facades\DB;
use App\Support\Service\BaseService;
use App\Domains\Users\Repositories\UserRepository;
use App\Domains\Companies\Repositories\CompanyRepository;
use App\Domains\Companies\Repositories\Criteria\JoinUserCriteria;
use App\Domains\Companies\Repositories\Filterable\CompanyBuilderFilter;

class CompanyService extends BaseService
{
    private $userRepository;

    public function __construct(CompanyRepository $repository, UserRepository $userRepository)
    {
        parent::__construct($repository);

        $this->userRepository = $userRepository;
    }

    /**
     * Lista todos as empresas.
     *
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function listAllCompanies(): array
    {
        DB::beginTransaction();

        try {

            $this->repository->pushCriteria(JoinUserCriteria::class);

            return [$companies, $perPage] = $this->repository->simplePaginate(app(CompanyBuilderFilter::class));

        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function store(array $data): bool
    {
        $dataUser = $data['user'];

        unset($data['user']);

        $userId = $this->userRepository->storeKeyResult($dataUser);

        $dataCompany = array_merge($data, ['user_id' => $userId]);

        return $this->repository->store($dataCompany);
    }

    public function amountSuppliersMonthlyPayment(int $companyKey): int
    {
        return $this->repository->amountSuppliersMonthlyPayment($companyKey);
    }
}
