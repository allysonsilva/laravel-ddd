<?php

namespace App\Domains\Users\Models\Traits;

use App\Units\Auth\Login;
use App\Domains\Users\Models\Role;
use App\Domains\Companies\Models\Company;
use App\Domains\Suppliers\Models\Supplier;

trait UserRelationship
{
    /**
     * Belongs-to relations with Login.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastLogin()
    {
        return $this->belongsTo(Login::class, 'last_login_id');
    }

    /**
     * Has-One relations with Company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    /**
     * Has-Many relations with Supplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'user_id');
    }

    /**
     * Belongs-to relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
