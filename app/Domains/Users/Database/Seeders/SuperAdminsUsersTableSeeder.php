<?php

namespace App\Domains\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Users\Models\User;

class SuperAdminsUsersTableSeeder extends Seeder
{
    /** @example php artisan db:seed --domain=Users --class=SuperAdminsUsersTableSeeder */
    public function run()
    {
        factory(User::class)->state('UserSuperAdmin')->times(5)->create([
            'is_enabled' => true,
        ]);
    }
}
