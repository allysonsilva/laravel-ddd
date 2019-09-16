<?php

namespace App\Domains\Companies\Models;

use App\Support\Models\BaseModel;
use App\Domains\Companies\Models\Traits\{
    CompanyRelationship,
    CompanyBoot
};

class Company extends BaseModel
{
    use CompanyRelationship,
        CompanyBoot;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'cnpj',
        'social_name',
        'fantasy_name',
        'phone',
        'address',
        'postal_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];
}
