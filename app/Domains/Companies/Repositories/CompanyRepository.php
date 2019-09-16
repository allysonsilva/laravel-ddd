<?php

namespace App\Domains\Companies\Repositories;

use App\Domains\Companies\Models\Company;
use App\Support\Repository\Eloquent\BaseRepository;

class CompanyRepository extends BaseRepository
{
    /**
     * For global tags in repository cache.
     *
     * @var array
     */
    protected $rememberCacheTag = ['companies', 'repository', 'cache'];

    protected const __DOMAIN = 'Companies';

    // Setting this property to NULL causes the cache to be forever.
    // protected $cacheSeconds;

    public function entity(): string
    {
        return Company::class;
    }

    public function domain(): string
    {
        return self::__DOMAIN;
    }

    /**
     * Calcula o total de todas as mensalidades dos fornecedores de determinada empresa.
     *
     * @param int $companyKey
     *
     * @return int
     */
    public function amountSuppliersMonthlyPayment(int $companyKey): int
    {
        $company = $this->entity->with('suppliers')->findOrFail($companyKey);

        $amount = 0;

        $company->suppliers->each(function($supplier, $key) use (&$amount) {
            $amount += $supplier->getOriginal('monthly_payment');
        });

        return $amount;
    }
}
