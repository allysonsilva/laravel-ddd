<?php

namespace App\Support\Specifications;

use App\Domains\Users\Models\User;
use App\Support\Specifications\Contracts\Specification;

class OrSpecification implements Specification
{
    private $specification;

    public function __construct(Specification ...$specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy(User $user): bool
    {
        foreach ($this->specification as $specification) {
            if ($specification->isSatisfiedBy($user)) {
                return true;
            }
        }

        return false;
    }
}
