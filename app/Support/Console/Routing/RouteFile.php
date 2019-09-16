<?php

namespace App\Support\Console\Routing;

use Illuminate\Contracts\Console\Kernel;

abstract class RouteFile
{
    /** @var \App\Core\Console\Kernel */
    protected $artisan;

    public function __construct()
    {
        $this->artisan = app(Kernel::class);
    }

    public function registerCommands()
    {
        $this->commands();
    }

    abstract protected function commands();
}
