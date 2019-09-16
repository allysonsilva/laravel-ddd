<?php

namespace App\Domains\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'PUT')
            return $this->user()->can('role', 'admin');

        return $this->user()->can('roleIs', 'SuperAdmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('douser');
        $userKey = optional($user)->getKey();

        /** Dados para validação */
        $rulesToValidate = [
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$userKey}",
            'status' => 'bail|sometimes|required',
        ];

        if ($this->method() === 'POST' || $this->filled('password')) {
            $rulesToValidate['password'] = 'bail|required|confirmed|min:6|max:255';
            $rulesToValidate['password_confirmation'] = 'bail|required|same:password';
        }

        if ($this->user()->roleIs('SuperAdmin')) {
            $rulesToValidate['role'] = 'bail|required|integer|exists:roles,id';
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
            'name' => 'Nome',
            'email' => 'E-mail',
            'role' => 'Permissão - Nível',
            'password' => 'Senha',
            'password_confirmation' => 'Confirmação da senha',
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

            if ($this->user()->roleIs('SuperAdmin')) {
                $this->merge(['role_id' => $this->input('role')]);
            } else {
                $this->offsetUnset('role_id');
            }

            if ($this->filled('password')) {
                $this->merge(['password' => bcrypt($this->input('password'))]);
            } else {
                $this->offsetUnset('password');
            }

            if ($this->method() === 'POST') {
                $this->merge(['email_verified_at' => now()]);
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
        if ($this->filled('status')) {
            $this->merge(['is_enabled' => true]);
        } else {
            $this->merge(['is_enabled' => false]);
        }

        $this->offsetUnset('status');
    }
}
