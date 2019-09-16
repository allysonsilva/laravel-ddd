<?php

namespace App\Support\Database\Console\Migrations;

use Illuminate\Database\Migrations\Migrator;
use App\Support\Database\Console\Migrations\Traits\MigrationPathsTrait;
use Illuminate\Database\Console\Migrations\StatusCommand as BaseStatusCommand;

class StatusCommand extends BaseStatusCommand
{
    use MigrationPathsTrait;

    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);
    }
}
