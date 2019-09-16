<?php

namespace App\Domains\Users\Models\Traits;

use App\Units\Auth\Login;

trait UserScope
{
    public function scopeWithLastLoginDate($query)
    {
        $query->addSelect([ 'last_login_date' => Login::select('created_at')->whereColumn('user_id', 'users.id')->latest()->limit(1) ]);
    }

    public function scopeWithLastLogin($query)
    {
        $query->addSelect([ 'last_login_id' => Login::select('id')
                                                     ->whereColumn('user_id', 'users.id')
                                                     ->latest()
                                                     ->limit(1) ])->with('lastLogin');
    }
}
