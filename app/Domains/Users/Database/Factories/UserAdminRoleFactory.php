<?php

namespace App\Domains\Users\Database\Factories;

use App\Domains\Users\Models\User;
use App\Domains\Users\Models\Admin;
use App\Support\Database\Eloquent\ModelFactory;

class UserAdminRoleFactory extends ModelFactory
{
    protected $model = User::class;

    public function define()
    {
        $this->factory->state($this->model, 'UserAdmin', function ($faker) {
            return $this->fields();
        });
    }

    protected function fields(): array
    {
        return [
            'role_id' => Admin::ROLE_ID,
        ];
    }
}
