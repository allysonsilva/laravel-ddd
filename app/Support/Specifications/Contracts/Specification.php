<?php

namespace App\Support\Specifications\Contracts;

use App\Domains\Users\Models\User;

interface Specification
{
    public function isSatisfiedBy(User $user): bool;
}
