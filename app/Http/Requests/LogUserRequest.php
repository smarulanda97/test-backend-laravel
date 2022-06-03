<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LogUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }

    /**
     * Defines custom json response when validation fails
     *
     * {@inheritDoc}
     */
    protected function failedValidation(Validator $validator) {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException(response()->json([
                'error' => true,
                'message' => 'invalid request parameters',
                'detail' => $validator->errors()
            ], 422));
        }
        parent::failedValidation($validator);
    }
}
