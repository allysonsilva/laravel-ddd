<?php

namespace App\Units\Auth\Services;

use App\Units\Auth\User;
use Illuminate\Support\Facades\Session;

class OneSessionPerUser
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute(): User
    {
        if (! empty($previousSession = $this->user->session_id)) {
            Session::getHandler()->destroy($previousSession);
        }

        $this->user->forceFill([
            'session_id' => Session::getId(),
        ])->save();

        return $this->user;
    }
}
