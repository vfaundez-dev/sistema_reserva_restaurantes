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
            'phone' => ['required','string', 'min:8'],
            'registration_date' => ['sometimes', 'date', 'after_or_equal:today']
        ];
    }

    protected function prepareForValidation() {
        if ($this->has('registrationDate')) {
            $this->merge([
                'registration_date' => $this->input('registrationDate')
            ]);
        }
    }

    public function attributes(): array {
        return [
            'registration_date' => 'registrationDate'
        ];
    }

}
