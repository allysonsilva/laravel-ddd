<?php

namespace App\Support\Database\Console\Migrations;

use Illuminate\Database\Migrations\Migrator;
use App\Support\Database\Console\Migrations\Traits\MigrationPathsTrait;
use Illuminate\Database\Console\Migrations\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
{
    use MigrationPathsTrait;

    /**
     * Create a new migration rollback command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator  $migrator
     * @return void
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);
    }
}
