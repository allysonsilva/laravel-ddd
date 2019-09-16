<?php

namespace App\Support\Service;

use App\Support\Service\Operations\{
    ServiceCreate as ServiceCreateOperation,
    ServiceRead as ServiceReadOperation,
    ServiceUpdate as ServiceUpdateOperation,
    ServiceDelete as ServiceDeleteOperation
};
use App\Support\Repository\Eloquent\BaseRepository;

class BaseService
{
    use ServiceCreateOperation,
        ServiceReadOperation,
        ServiceUpdateOperation,
        ServiceDeleteOperation;

    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }
}
