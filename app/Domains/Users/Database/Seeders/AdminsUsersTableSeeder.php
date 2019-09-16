<?php

namespace App\Domains\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Users\Models\User;

class AdminsUsersTableSeeder extends Seeder
{
    /** @example php artisan db:seed --domain=Users --class=AdminsUsersTableSeeder */
    public function run()
    {
        factory(User::class)->state('UserAdmin')->times(10)->create();
    }
}
