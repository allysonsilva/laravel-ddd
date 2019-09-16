<?php

namespace App\Domains\Users\Models\Traits;

use Illuminate\Support\Str;

trait UserBoot
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function(self $user)
        {
            /**
             * Indica se a trait [SoftDeletes] está desabilitada
             */
            if (FALSE === method_exists($user, 'trashed')) {
                $user->load('company');

                if ($user->relationLoaded('company') &&
                    ! empty($user->getRelation('company'))) {
                        $user->company->delete();
                }
            }

            return true;
        });

        static::creating(function (self $user) {
            $user->uuid = (string) Str::uuid();
            // $user->{$user->getKeyName()} = (string) Str::uuid();
        });

        // static::addGlobalScope(function ($query) {
        //     $query->withLastLogin();
        // });
    }
}
