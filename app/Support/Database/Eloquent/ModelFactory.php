<?php

namespace App\Support\Database\Eloquent;

use Faker\Generator as FakerGenerator;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

abstract class ModelFactory
{
    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    protected $factory;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct()
    {
        $this->factory = app(EloquentFactory::class);
        $this->faker = app(FakerGenerator::class);
    }

    protected function bootWithProviders(): void
    {
        //
    }

    public function define()
    {
        $this->bootWithProviders();

        $this->factory->define($this->model, function () {
            return $this->fields();
        });
    }

    abstract protected function fields(): array;
}
