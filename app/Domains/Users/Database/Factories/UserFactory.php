<?php

namespace App\Domains\Users\Database\Factories;

use Illuminate\Support\Str;
use App\Domains\Users\Models\User;
use App\Support\Database\Eloquent\ModelFactory;

class UserFactory extends ModelFactory
{
    protected $model = User::class;

    protected function fields(): array
    {
        static $password;

        return [
            'uuid' => Str::uuid(),
            'is_enabled' => $this->faker->randomElement([false, true]),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            // 'last_login_at' => now(),
            'password' => $password ?: $password = bcrypt('secret'),
            // 'api_token' => hash('sha256', Str::random(60)),
            // 'remember_token' => Str::random(10),
        ];
    }
}
