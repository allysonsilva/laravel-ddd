<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    /**
     * Admin user role {id}.
     *
     * @var int
     */
    public const ROLE_ID = 2;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('UserRoleAdmin', function (Builder $query) {
            $query->where('role_id', self::ROLE_ID);
        });
    }
}
