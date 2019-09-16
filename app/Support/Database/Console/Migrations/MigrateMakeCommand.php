<?php

namespace App\Support\Database\Console\Migrations;

use Illuminate\Support\Str;
use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;
use App\Support\Database\Console\Migrations\Traits\MigrationPathsTrait;
use App\Support\Database\Console\Migrations\Contracts\MigrationConstants;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand as BaseMigrateMakeCommand;

class MigrateMakeCommand extends BaseMigrateMakeCommand
{
    use MigrationPathsTrait;

    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator  $creator
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        /**
         * Adding Domain Option to the Command.
         *
         * @example php artisan make:migration create_users_table Users
         */
        $this->signature .= "
            {domain : Name of the domain folder}";

        parent::__construct($creator, $composer);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMigrationPath()
    {
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return ! $this->usingRealPath()
                            ? $this->laravel->basePath().'/'.$targetPath
                            : $targetPath;
        }

        $domain = Str::studly(trim($this->input->getArgument('domain')));

        return domain_component_path($domain, MigrationConstants::MIGRATION_PATH_DOMAIN);
    }
}
