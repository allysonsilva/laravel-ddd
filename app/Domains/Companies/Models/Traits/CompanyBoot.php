<?php

namespace App\Domains\Companies\Models\Traits;

trait CompanyBoot
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function(self $company)
        {
            /**
             * Indica se a trait [SoftDeletes] está desabilitada
             */
            if (FALSE === method_exists($company, 'trashed')) {
                $company->load('suppliers');

                $company->suppliers->each(function($supplier, $key) {
                    $supplier->delete();
                });

                // if ($company->user()->exists()) {
                //     $company->user()->delete();
                // }
            }

            return true;
        });
    }
}
