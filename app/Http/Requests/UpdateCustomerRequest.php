<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateCustomerRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ( $this->method() === 'PUT' ) {
            return [
                'name' => ['required', 'string', 'min:3'],
                'email' => ['required', 'email', Rule::unique(table: 'customers')->ignore( $this->route('customer') )],
                'phone' => ['required', 'string', 'min:8'],
                'registrationDate' => ['required', 'date']
            ];
        } else {
            return [
                'name' => ['sometimes', 'required', 'string', 'min:3'],
                'email' => ['sometimes', 'required', 'email', Rule::unique(table: 'customers')->ignore( $this->route('customer') )],
                'phone' => ['sometimes', 'required', 'string', 'min:8'],
                'registrationDate' => ['sometimes', 'required', 'date']
            ]; 
        }
    }

    protected function prepareForValidation() {
        if ($this->has('registrationDate')) {
            $this->merge([
                'registration_date' => $this->registrationDate
            ]);
        }
    }

    public function attributes(): array {
        return [
            'registration_date' => 'registrationDate'
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
