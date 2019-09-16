<?php

namespace App\Domains\Companies\Database\Factories;

use App\Domains\Companies\Models\Company;
use App\Support\Database\Eloquent\ModelFactory;

class CompanyFactory extends ModelFactory
{
    protected $model = Company::class;

    protected function bootWithProviders(): void
    {
        $this->faker->addProvider(new \Faker\Provider\pt_BR\Company($this->faker));
    }

    protected function fields(): array
    {
        return [
            'cnpj' => $this->faker->cnpj,
            'social_name' => $this->faker->company,
            'fantasy_name' => $this->faker->sentence($this->faker->numberBetween(3, 5)),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
        ];
    }
}
