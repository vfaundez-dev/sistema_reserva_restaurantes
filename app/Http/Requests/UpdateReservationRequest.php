<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateReservationRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'reservation_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'reservation_time' => ['sometimes', 'date_format:H:i'],
            'number_of_peoples' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', 'in:pending,confirmed,cancelled'],
            'notes' => ['sometimes', 'string', 'max:255'],
            'customer_id' => ['sometimes', 'exists:customers,id'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'table_ids' => ['sometimes', 'array', 'min:1'],
            'table_ids.*' => ['exists:tables,id'],
        ];
    }

    protected function prepareForValidation() {

        collect([
            'customer' => 'customer_id',
            'user' => 'user_id',
            'tables' => 'table_ids',
        ])->each(function ($attribute, $key) {
            if ($this->has($key)) {
                $this->merge( [$attribute => $this->input($key)] );
            }
        });
    }

    public function attributes(): array {
        return [
            'customer_id' => 'customer',
            'user_id' => 'user',
            'table_ids' => 'tables',
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
