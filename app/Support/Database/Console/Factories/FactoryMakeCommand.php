<?php

namespace App\Support\Database\Console\Factories;

use App\Support\Database\Console\Traits\{
    DomainArgument,
    DomainComponentNamespace,
    DefaultToGeneratorCommand
};
use Illuminate\Database\Console\Factories\FactoryMakeCommand as BaseFactoryMakeCommand;

class FactoryMakeCommand extends BaseFactoryMakeCommand
{
    use DomainArgument,
        DomainComponentNamespace,
        DefaultToGeneratorCommand;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory Domain';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/factory.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildClass($name)
    {
        $namespaceModel = $this->option('model')
                        ? $this->qualifyClass($this->option('model'))
                        : trim($this->rootNamespace(), '\\').'\\Model';

        $model = class_basename($namespaceModel);

        return str_replace(
            [
                'NamespacedDummyModel',
                'DummyModel',
            ],
            [
                $namespaceModel,
                $model,
            ],
            parent::buildClass($name)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->getDomainComponentNamespace('Database\\Factories', $rootNamespace);
    }
}
