<?php

namespace App\Domains\Companies\Models\Traits;

use App\Domains\Users\Models\User;
use App\Domains\Suppliers\Models\Supplier;

trait CompanyRelationship
{
    /**
     * Belongs-to relations with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Has-Many relations with Supplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'company_id');
    }
}
