<?php

namespace App\Domains\Users\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RolesTableSeeder::class);
        $this->call(SuperAdminsUsersTableSeeder::class);
        $this->call(AdminsUsersTableSeeder::class);
        $this->call(CompaniesUsersTableSeeder::class);
    }
}
