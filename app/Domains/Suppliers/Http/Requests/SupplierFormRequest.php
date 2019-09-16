<?php

namespace App\Domains\Suppliers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pipeline\Pipeline as BasePipeline;
use App\Domains\Suppliers\Pipelines\SanitizeMonthlyPayment;

class SupplierFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();

        if ($this->isMethod('POST')) {
            return $user->can('roleIs', 'Company');
        }

        return $user->can('role', 'Company');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $supplier = $this->route('dosupplier');
        $supplierKey = optional($supplier)->getKey();

        /** Dados para validação */
        $rulesToValidate = [
            'name' => 'required|string',
            'email' => "required|email|unique:suppliers,email,{$supplierKey}",
            'status' => 'sometimes|nullable|required',
            'monthly_payment' => 'required|numeric',
        ];

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
            'name' => 'Nome do fornecedor',
            'email' => 'E-mail do fornecedor',
            'monthly_payment' => 'Valor da mensalidade do fornecedor',
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
        //
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // if ($this->filled('status')) {
        //     $this->merge(['is_activated' => true]);
        // } else {
        //     $this->merge(['is_activated' => false]);
        // }

        if ($this->filled('monthly_payment')) {
            $sanitizeMonthlyPayment =
                            // @see https://jeffochoa.me/understanding-laravel-pipelines
                            app(BasePipeline::class)
                            ->send($this->monthly_payment)
                            ->through([SanitizeMonthlyPayment::class])
                            ->thenReturn();

            $this->merge(['monthly_payment' => $sanitizeMonthlyPayment]);
        }

        $this->offsetUnset('status');

        if ($this->isMethod('POST')) {
            $user = auth()->user();

            $this->merge(['user_id' => $user->getKey()]);
            $this->merge(['company_id' => $user->company->getKey()]);
        }
    }
}
