<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTableRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'table_number' => ['required', 'integer', 'min:1', 'unique:tables,table_number'],
            'is_available' => ['sometimes', 'boolean'],
            'capacity' => ['required', 'integer', 'min:2', 'max:10'],
            'location' => ['required', Rule::in(['indoor', 'outdoor'])],
        ];
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
            'table_number' => 'tableNumber',
            'is_available' => 'isAvailable',
        ];
    }

}
