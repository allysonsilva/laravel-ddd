<?php

namespace App\Domains\Suppliers\Services;

use App\Support\Service\BaseService;
use App\Domains\Suppliers\Repositories\SupplierRepository;

class SupplierService extends BaseService
{
    public function __construct(SupplierRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(array $data): bool
    {
        return parent::store($data);
    }

    public function activation(int $supplierKey): bool
    {
        return $this->repository->update(['is_activated' => true, 'activated_at' => now()], $supplierKey);
    }
}
