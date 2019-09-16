<?php

namespace App\Domains\Companies\Http\Requests;

use App\Domains\Users\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CompanyFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('role', 'Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company = $this->route('docompany');
        $companyKey = optional($company)->getKey();

        /** Dados para validação */
        $rulesToValidate = [
            'cnpj' => ['required', 'numeric', 'digits:14', "unique:companies,cnpj,{$companyKey}"],
            'social_name' => ['required', 'string', 'max:255'],
            'fantasy_name' => ['required', 'string', 'max:255'],
            'phone' => 'required|numeric|digits_between:8,15',
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'numeric', 'digits:8'],
        ];

        if ($this->isMethod('POST')) {
            $rulesToValidate['user.name'] = 'required|string';
            $rulesToValidate['user.email'] = 'required|email|unique:users,email';
            $rulesToValidate['user.password'] = 'required|confirmed|min:6|max:255';
            // $rulesToValidate['user.password_confirmation'] = 'required|same:password';
        }

        return $rulesToValidate;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user.name' => 'Nome do usuário',
            'user.email' => 'E-mail do usuário',
            'user.password' => 'Senha do usuário',
            'user.password_confirmation' => 'Confirmação da senha',
            'cnpj' => 'CNPJ da empresa',
            'social_name' => 'Razão social da empresa',
            'fantasy_name' => 'Nome fantasia da empresa',
            'phone' => 'Telefone da empresa',
            'address' => 'Endereço completo da empresa',
            'postal_code' => 'CEP da empresa',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->isMethod('POST')) {
                $dataUser = $this->get('user');

                $dataUser['role_id'] = (Role::whereCode('company')->firstOrFail())->getKey();
                $dataUser['password'] = bcrypt($this->input('password'));
                $dataUser['email_verified_at'] = now();
                $dataUser['is_enabled'] = true;

                $this->merge(['user' => $dataUser]);
            }

        });
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->offsetUnset('user.role_id');
        $this->offsetUnset('user.is_enabled');
        $this->offsetUnset('user.password');

        $this->offsetUnset('_token');
    }
}
