<?php

namespace App\Http\Requests;

use App\Rules\CheckExpression;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CalculateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expression' => [new CheckExpression]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->error($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
