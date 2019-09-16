<?php

namespace App\Domains\Users\Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        populate_table_by_file($this->command, 'roles', __DIR__.DIRECTORY_SEPARATOR.'SQL'.DIRECTORY_SEPARATOR.'roles.sql');
    }
}
