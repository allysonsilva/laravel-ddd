<?php

namespace App\Units\Auth\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Units\Auth\Http\Controllers\Api\Controller as BaseController;
use App\Units\Auth\Services\StoreUserAndCompany as StoreUserAndCompanyService;

class RegisterController extends BaseController
{
    /** @var \Illuminate\Http\Request */
    private $request;

    /**
     * Create a new Controller instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->middleware('guest:api');
    }

    /**
     * Register user for application.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Units\Auth\Services\StoreUserAndCompany $service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, StoreUserAndCompanyService $service): JsonResponse
    {
        $this->validateRegister($request);

        DB::beginTransaction();

        try {
            /** @var \App\Units\Auth\User */
            $user = $service->execute($request->all());

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return $this->respondStandard('ERROR_REGISTERING_USER', 'Não foi possíve realizar registro, verifique os dados e tente novamente.', HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Alias to generate a token for a given user
        /** @var string */
        $token = auth('api')->login($user);

        return $this->respondWithToken($token, HttpResponse::HTTP_CREATED, compact('user'));
    }

    /**
     * Validate the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    private function validateRegister(Request $request): void
    {
        $this->validate($request, [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user.password' => ['required', 'string', 'min:6', 'confirmed'],
            'company.cnpj' => ['required', 'numeric', 'digits:14', 'unique:companies,cnpj'],
            'company.social_name' => ['required', 'string', 'max:255'],
            'company.fantasy_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'company.phone' => 'sometimes|nullable|numeric|digits_between:8,15',
            'company.address' => ['sometimes', 'nullable', 'string', 'max:255'],
            'company.postal_code' => ['sometimes', 'nullable', 'numeric', 'digits:8'],
        ], [], [
            'user.name' => 'Nome do usuário',
            'user.email' => 'E-mail do usuário',
            'user.password' => 'Password do usuário',
            'company.cnpj' => 'CNPJ da empresa',
            'company.social_name' => 'Razão social da empresa',
            'company.fantasy_name' => 'Nome fantasia da empresa',
            'company.phone' => 'Telefone da empresa',
            'company.address' => 'Endereço completo da empresa',
            'company.postal_code' => 'CEP da empresa',
        ]);
    }
}
