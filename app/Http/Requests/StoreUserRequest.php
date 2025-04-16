<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Spatie\Permission\Models\Role;

class StoreUserRequest extends FormRequest {
    
    public function authorize(): bool {

        if (!auth()->check()) {
            return false;
        }

        return $this->user()->can('create users');
    }

    public function rules(): array {

        $user = auth()->user();
        $availableRoles = Role::all()->pluck('name')->toArray();

        // Only administrators can assign administrator roles
        if (!$user->hasRole('administrator')) {
            $availableRoles = array_filter($availableRoles, fn($role) => $role !== 'administrator');
        }

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(6)->letters()->numbers()->symbols()->mixedCase()],
            'role' => ['required', 'string', 'in:'.implode(',', $this->getAvailableRoles())],
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Request validation errors',
            'data' => $validator->errors()
        ], 422));
    }

    protected function getAvailableRoles(): array {
        $availableRoles = Role::all()->pluck('name')->toArray();

        // Only administrators can assign administrator roles
        if (!auth()->user()->hasRole('administrator')) {
            $availableRoles = array_filter($availableRoles, fn($role) => $role !== 'administrator');
        }

        return $availableRoles;
    }

}
