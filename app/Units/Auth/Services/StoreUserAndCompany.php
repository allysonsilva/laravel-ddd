<?php

namespace App\Units\Auth\Services;

use App\Units\Auth\User;
use App\Domains\Users\Models\Role;
use Illuminate\Auth\Events\Registered;
use App\Domains\Users\Repositories\UserRepository;
use App\Domains\Companies\Repositories\CompanyRepository;

class StoreUserAndCompany
{
    private $userRepository;
    private $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function execute(array $data): User
    {
        ['user' => $dataUser, 'company' => $dataCompany] = $data;

        $dataUser = array_merge($dataUser, ['password' => bcrypt($dataUser['password']), 'is_enabled' => true]);
        $dataUser['role_id'] = (Role::whereCode('company')->firstOrFail())->getKey();

        $userKey = $this->userRepository->storeKeyResult($dataUser);

        $dataCompany['user_id'] = $userKey;

        $this->companyRepository->store($dataCompany);

        event(new Registered($user = User::findOrFail($userKey)));

        return $user;
    }
}
