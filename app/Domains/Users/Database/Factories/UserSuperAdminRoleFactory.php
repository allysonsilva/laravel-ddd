<?php

namespace App\Domains\Users\Database\Factories;

use App\Domains\Users\Models\User;
use App\Domains\Users\Models\SuperAdmin;
use App\Support\Database\Eloquent\ModelFactory;

class UserSuperAdminRoleFactory extends ModelFactory
{
    protected $model = User::class;

    public function define()
    {
        $this->factory->state($this->model, 'UserSuperAdmin', function ($faker) {
            return $this->fields();
        });
    }

    protected function fields(): array
    {
        // static $roleCompanyId;

        return [
            'role_id' => SuperAdmin::ROLE_ID,
            // 'role_id' => $roleCompanyId ?: $roleCompanyId = Role::where('code', 'super-admin')->firstOrFail()->getKey(),
        ];
    }
}
