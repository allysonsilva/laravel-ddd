<?php

namespace App\Domains\Suppliers\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Users\Models\User;
use App\Domains\Suppliers\Models\Supplier;

class SuppliersTableSeeder extends Seeder
{
    /** @example php artisan db:seed --domain=Suppliers --class=SuppliersTableSeeder */
    public function run()
    {
        $users = User::query()
                    ->whereHas('role', function($query) {
                        return $query->whereCode('company');
                    })
                    ->with('company')
                    ->get();

        $users->each(function($user) {

            factory(Supplier::class, 5)->create([
                'user_id' => $user->getKey(),
                'company_id' => $user->company->getKey(),
            ]);

        });
    }
}
