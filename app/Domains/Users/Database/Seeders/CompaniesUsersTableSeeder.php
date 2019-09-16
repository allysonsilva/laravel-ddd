<?php

namespace App\Domains\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Users\Models\User;

class CompaniesUsersTableSeeder extends Seeder
{
    /** @example php artisan db:seed --domain=Users --class=CompaniesUsersTableSeeder */
    public function run()
    {
        factory(User::class)->state('UserCompany')->times(10)->create();
    }
}
