<?php

namespace App\Domains\Users\Database\Factories;

use App\Domains\Users\Models\User;
use App\Support\Database\Eloquent\ModelFactory;
use App\Domains\Users\Models\Company as UserCompany;

class UserCompanyRoleFactory extends ModelFactory
{
    protected $model = User::class;

    public function define()
    {
        // @see https://laravel-news.com/going-deeper-with-factories-through-factory-states

        $this->factory->state($this->model, 'UserCompany', function ($faker) {
            return $this->fields();
        })
        ->afterCreatingState($this->model, 'UserCompany', function ($user, $faker) {
            $user->company()->save(factory(\App\Domains\Companies\Models\Company::class)->make());
            // factory(\App\Domains\Companies\Models\Company::class)->create([
            //     'user_id' => $user->getKey(),
            // ]);
        });
    }

    protected function fields(): array
    {
        return [
            'role_id' => UserCompany::ROLE_ID,
        ];
    }
}
