<?php

namespace App\Support\Database\Console\Migrations\Traits;

use DirectoryIterator;
use Illuminate\Support\Arr;
use Symfony\Component\Finder\Finder;
use App\Support\Database\Console\Migrations\Contracts\MigrationConstants as InterfaceConstants;

trait MigrationPathsTrait
{
    /**
     * {@inheritdoc}
     *
     * @see \Illuminate\Database\Console\Migrations\BaseCommand::getMigrationPaths()
     */
    protected function getMigrationPaths()
    {
        // Here, we will check to see if a path option has been defined. If it has we will
        // use the path relative to the root of the installation folder so our database
        // migrations may be run for any customized path from within the application.
        if ($this->input->hasOption('path') && $this->option('path')) {
            return collect($this->option('path'))->map(function ($path) {
                return ! $this->usingRealPath()
                                ? $this->laravel->basePath().'/'.$path
                                : $path;
            })->all();
        }

        // Checking Migrations by Domains
        if ($this->input->hasOption('domain') && $domains = $this->option('domain')) {
            return collect($domains)->map(function ($domain) {

                return ! $this->usingRealPath()
                                ? domain_component_path($domain, InterfaceConstants::MIGRATION_PATH_DOMAIN)
                                : $domain;

            })->all();
        }

        $domainsComponentsPath = paths_inside_components_domains(InterfaceConstants::MIGRATION_PATH_DOMAIN);

        return array_merge($this->migrator->paths(), Arr::wrap($this->getMigrationPath()), $domainsComponentsPath);
    }

    /**
     * Determine if the given path(s) are pre-resolved "real" paths.
     *
     * @return bool
     */
    protected function usingRealPath()
    {
        return $this->input->hasOption('realpath') && $this->option('realpath');
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }
}
