<?php

namespace App\Units\Auth\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Units\Auth\Services\StoreUserAndCompany as StoreUserAndCompanyService;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth::register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Units\Auth\Services\StoreUserAndCompany $service
     *
     * @return void
     */
    public function register(Request $request, StoreUserAndCompanyService $service)
    {
        $this->validator($request->all())->validate();

        DB::transaction(function () use (&$service, &$request) {
            /** @var \App\Units\Auth\User */
            $user = $service->execute($request->all());

            auth('web')->login($user);
        });

        $message = <<<EOT
        Nova conta criada com sucesso. Favor confirmar e-mail de verificação na sua caixa de entrada para ter acesso aos recursos do sistema.
EOT;

        return redirect()->route('dashboard.index')->with('success', $message);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
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
