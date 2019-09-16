<?php

namespace App\Support\Database\Console\Migrations;

use Illuminate\Database\Migrations\Migrator;
use App\Support\Database\Console\Migrations\Traits\MigrationPathsTrait;
use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    use MigrationPathsTrait;

    /**
     * Create a new migration command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator  $migrator
     *
     * @return void
     */
    public function __construct(Migrator $migrator)
    {
        /**
         * Adding Domain Option to the Command.
         *
         * @example php artisan migrate --domain=Categories --domain=Products
         */
        $this->signature .= "
            {--D|domain=* : Name of the domain folder}";

        parent::__construct($migrator);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Illuminate\Database\Console\Migrations\MigrateCommand::handle()
     */
    public function handle()
    {
        parent::handle();
    }
}
