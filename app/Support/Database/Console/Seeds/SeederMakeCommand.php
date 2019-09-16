<?php

namespace App\Support\Database\Console\Seeds;

use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use App\Support\Database\Console\Traits\{
    DomainArgument,
    DomainComponentNamespace,
    DefaultToGeneratorCommand
};
use Illuminate\Database\Console\Seeds\SeederMakeCommand as BaseSeederMakeCommand;

class SeederMakeCommand extends BaseSeederMakeCommand
{
    use DomainArgument,
        DomainComponentNamespace,
        DefaultToGeneratorCommand;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files, $composer);
    }

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->getDomainComponentNamespace('Database\\Seeders', $rootNamespace);
    }
}
