<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateTableRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ( $this->method() === 'PUT' ) {
            return [
                'is_available' => ['sometimes', 'boolean'],
                'capacity' => ['required', 'integer', 'min:2', 'max:10'],
                'location' => ['required', Rule::in(['indoor', 'outdoor'])],
            ];
        } else {
            return [
                'is_available' => ['sometimes', 'boolean'],
                'capacity' => ['sometimes', 'required', 'integer', 'min:2', 'max:10'],
                'location' => ['sometimes', 'required', Rule::in(['indoor', 'outdoor'])],
            ];
        }
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Request validation errors',
            'data' => $validator->errors()
        ], 422));
    }

}
