<?php

namespace App\Support\Validator;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

abstract class FormRequestValidator extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * Automatically authorize any request by default.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
