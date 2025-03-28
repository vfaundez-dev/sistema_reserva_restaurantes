<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ($this->method() === 'PUT') {
            return [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', Rule::unique(table: 'users')->ignore( $this->route('user') )],
                'role_id' => ['required', 'numeric', 'exists:App\Models\Role,id'],
                'password' => ['sometimes', 'required', 'string', Password::min(6)->letters()->numbers()->symbols()->mixedCase()],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required', 'string', 'max:100'],
                'email' => ['sometimes', 'required', 'email', Rule::unique(table: 'users')->ignore( $this->route('user') )],
                'role_id' => ['sometimes', 'required', 'numeric', 'exists:App\Models\Role,id'],
                'password' => ['sometimes', 'required', 'string', Password::min(6)->letters()->numbers()->symbols()->mixedCase()],
            ];
        }
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
