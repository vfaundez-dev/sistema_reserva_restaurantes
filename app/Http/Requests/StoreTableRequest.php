<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreTableRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'is_available' => ['sometimes', 'boolean'],
            'capacity' => ['required', 'integer', 'min:2', 'max:10'],
            'location' => ['required', Rule::in(['indoor', 'outdoor'])],
        ];
    }

    protected function prepareForValidation() {
        if ($this->has('isAvailable')) {
            $this->merge([
                'is_available' => $this->input('isAvailable')
            ]);
        }
    }

    public function attributes(): array {
        return [
            'is_available' => 'isAvailable',
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Request validation errors',
            'data' => $validator->errors()
        ], 422));
    }

}
