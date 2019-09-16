<?php

namespace App\Units\Auth\Services;

use App\Units\Auth\User;
use App\Units\Auth\Login;

class UpdateUserLastLogin
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute(): User
    {
        $login = app(Login::class);
        $login->fill([
            'user_id' => $this->user->getKey(),
            'ip_address' => request()->getClientIp(),
        ]);
        $login->saveQuietly();

        $this->user->forceFill([
            'last_login_at' => now(),
            'last_login_id' => $login->getKey(),
        ])->save();

        return $this->user;
    }
}
