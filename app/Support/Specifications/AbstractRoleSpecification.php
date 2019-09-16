<?php

namespace App\Support\Specifications;

use App\Domains\Users\Models\User;
use App\Support\Specifications\Contracts\Specification;

abstract class AbstractRoleSpecification implements Specification
{
    protected $role;

    public function isSatisfiedBy(User $user)
    {
        return $user->hasRole($this->role);
    }
}
