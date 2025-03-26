<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'phone' => ['nullable','string', 'min:8'],
            'registration_date' => ['date', 'after_or_equal:today']
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'registration_date' => $this->registrationDate // Mapeamos a nombre de columna DB
        ]);
    }

    public function attributes(): array {
        return [
            'registration_date' => 'registrationDate'
        ];
    }
    
}
