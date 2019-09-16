<?php

namespace App\Domains\Suppliers\Models\Traits;

use App\Domains\Users\Models\User;
use App\Domains\Companies\Models\Company;

trait SupplierRelationship
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
     * Belongs-to relations with Company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
