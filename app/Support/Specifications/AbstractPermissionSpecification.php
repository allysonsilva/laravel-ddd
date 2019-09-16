<?php

namespace App\Support\Specifications;

use App\Domains\Users\Models\User;
use App\Support\Specifications\Contracts\Specification;

abstract class AbstractPermissionSpecification implements Specification
{
    protected $permission;

    public function isSatisfiedBy(User $user)
    {
        return $user->allow($this->permission);
    }
}
