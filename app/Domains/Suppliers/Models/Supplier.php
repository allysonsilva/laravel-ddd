<?php

namespace App\Domains\Suppliers\Models;

use App\Support\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use App\Domains\Suppliers\Models\Traits\{
    SupplierRelationship,
    SupplierFunction
};
use App\Domains\Suppliers\Models\Traits\Boots\QueryFilterSuppliersByUsers;

class Supplier extends BaseModel
{
    use SupplierRelationship,
        SupplierFunction,
        QueryFilterSuppliersByUsers,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'email',
        'monthly_payment',
        'is_activated',
        'activated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'company_id' => 'integer',
        'monthly_payment' => 'decimal:15',
        'is_activated' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'activated_at',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Setup event bindings...
    }
}
