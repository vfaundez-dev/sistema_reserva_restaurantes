<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreReservationRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    
    public function rules(): array {
        return [
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'reservation_time' => ['required', 'date_format:H:i'],
            'number_of_peoples' => ['required', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', 'in:pending,confirmed,cancelled'],
            'notes' => ['required', 'string', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id'],
            'user_id' => ['required', 'exists:users,id'],
            'table_ids' => 'required|array|min:1',
            'table_ids.*' => 'exists:tables,id',
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'customer_id' => $this->input('customer'),
            'user_id' => $this->input('user'),
            'table_ids' => $this->input('tables'),
        ]);
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
