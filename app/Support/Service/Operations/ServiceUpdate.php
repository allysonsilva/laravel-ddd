<?php

namespace App\Support\Service\Operations;

trait ServiceUpdate
{
    public function update(array $attributes, $modelOrId): bool
    {
        return $this->repository->update($attributes, $modelOrId);
    }
}
