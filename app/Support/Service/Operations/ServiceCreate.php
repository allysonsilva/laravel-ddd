<?php

namespace App\Support\Service\Operations;

use Illuminate\Database\Eloquent\Model;

trait ServiceCreate
{
    public function store(array $attributes): bool
    {
        return $this->repository->store($attributes);
    }
}
