<?php

namespace App\Support\Database\Console\Migrations\Contracts;

interface MigrationConstants
{
    /**
     * Default path of the migration files in each application domain.
     *
     * @var string
     */
    const MIGRATION_PATH_DOMAIN = 'Database'.DIRECTORY_SEPARATOR.'Migrations';
}
