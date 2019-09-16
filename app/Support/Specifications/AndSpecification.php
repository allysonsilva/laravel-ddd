<?php

namespace App\Support\Specifications;

use App\Domains\Users\Models\User;
use App\Support\Specifications\Contracts\Specification;

class AndSpecification implements Specification
{
    private $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(User $user): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($user)) {
                return false;
            }
        }

        return true;
    }
}
