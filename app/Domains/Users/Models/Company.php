<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Builder;

class Company extends User
{
    /**
     * Company user role {id}.
     *
     * @var int
     */
    public const ROLE_ID = 3;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('UserRoleCompany', function (Builder $query) {
            $query->where('role_id', self::ROLE_ID);
        });
    }
}
