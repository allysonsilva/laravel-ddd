<?php

namespace App\Domains\Users\Models;

use App\Support\Models\BaseModel;
use App\Domains\Users\Models\Traits\RoleRelationship;

class Role extends BaseModel
{
    use RoleRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'level',
    ];
}
