<?php

namespace App\Domains\Suppliers\Database\Factories;

use App\Domains\Suppliers\Models\Supplier;
use App\Support\Database\Eloquent\ModelFactory;

class SupplierFactory extends ModelFactory
{
    protected $model = Supplier::class;

    protected function fields(): array
    {
        return [
            'is_activated' => $isActivated = $this->faker->randomElement([false, true]),
            'activated_at' => ($isActivated === TRUE) ? now() : null,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'monthly_payment' => $this->faker->randomFloat(2, 5000, 10000),
        ];
    }
}
