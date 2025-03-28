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
                'table_number' => ['required', 'integer', 'min:1', Rule::unique(table: 'tables')->ignore( $this->route('table') )],
                'is_available' => ['sometimes', 'boolean'],
                'capacity' => ['required', 'integer', 'min:2', 'max:10'],
                'location' => ['required', Rule::in(['indoor', 'outdoor'])],
            ];
        } else {
            return [
                'table_number' => ['sometimes', 'required', 'integer', 'min:1', Rule::unique(table: 'tables')->ignore( $this->route('table') )],
                'is_available' => ['sometimes', 'boolean'],
                'capacity' => ['sometimes', 'required', 'integer', 'min:2', 'max:10'],
                'location' => ['sometimes', 'required', Rule::in(['indoor', 'outdoor'])],
            ];
        }
    }

    protected function prepareForValidation() {
        collect([
            'tableNumber' => 'table_number',
            'isAvailable' => 'is_available'
        ])->each(function ($attribute, $key) {
            if ($this->has($key)) {
                $this->merge( [$attribute => $this->input($key)] );
            }
        });
    }

    public function attributes(): array {
        return [
            'table_number' => 'tableNumber'
        ];
    }
}
