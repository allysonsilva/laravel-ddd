<?php

namespace App\Domains\Users\Models\Traits;

use App\Domains\Users\Models\User;

trait RoleRelationship
{
    /**
     * Has-Many relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
