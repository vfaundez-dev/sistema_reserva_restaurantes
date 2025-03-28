<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role_id' => ['required', 'numeric', 'exists:App\Models\Role,id'],
            'password' => ['required', 'string', Password::min(6)->letters()->numbers()->symbols()->mixedCase()],
        ];
    }

    protected function prepareForValidation() {
        if ($this->has('role')) {
            $this->merge([
                'role_id' => $this->input('role')
            ]);
        }
    }

    public function attributes(): array {
        return [
            'role_id' => 'role'
        ];
    }

}
