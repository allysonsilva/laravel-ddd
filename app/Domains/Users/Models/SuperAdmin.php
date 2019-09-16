<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Builder;

class SuperAdmin extends User
{
    /**
     * Super admin user role {id}.
     *
     * @var int
     */
    public const ROLE_ID = 1;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('UserRoleSuperAdmin', function (Builder $query) {
            $query->where('role_id', self::ROLE_ID);
        });
    }
}
