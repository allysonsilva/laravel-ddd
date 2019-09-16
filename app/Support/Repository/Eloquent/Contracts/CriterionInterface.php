<?php

namespace App\Support\Repository\Eloquent\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CriterionInterface
{
    public function apply(object &$builder, RepositoryInterface $repository): object;
}
