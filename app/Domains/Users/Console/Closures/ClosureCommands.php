<?php

namespace App\Domains\Users\Console\Closures;

use App\Support\Console\Routing\RouteFile;

/*
|--------------------------------------------------------------------------
| Console Closures
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

class ClosureCommands extends RouteFile
{
    public function commands()
    {
        // $this->artisan->command('build {project}', function ($project) {
        //     $this->info("Building {$project}!");
        // });
    }
}
