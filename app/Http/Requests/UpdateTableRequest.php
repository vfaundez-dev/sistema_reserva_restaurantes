<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

    protected function prepareForValidation() {
        if ($this->has('isAvailable')) {
            $this->merge([
                'is_available' => $this->input('isAvailable')
            ]);
        }
    }

    public function attributes(): array {
        return [
            'is_available' => 'isAvailable'
        ];
    }
}
