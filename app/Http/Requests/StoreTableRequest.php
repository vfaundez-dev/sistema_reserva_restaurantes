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
            'capacity' => ['required', 'integer', 'min:2', 'max:10'],
            'location' => ['required', Rule::in(['indoor', 'outdoor'])],
        ];
    }

    protected function prepareForValidation() {
        if ($this->has('tableNumber')) {
            $this->merge([
                'table_number' => $this->input('tableNumber')
            ]);
        }
    }

    public function attributes(): array {
        return [
            'table_number' => 'tableNumber'
        ];
    }

}
