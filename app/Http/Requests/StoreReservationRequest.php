<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    
    public function rules(): array {
        return [
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'status' => ['sometimes', 'string', 'in:pending,confirmed,cancelled'],
            'notes' => ['required', 'string', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id'],
            'table_id' => ['required', 'exists:tables,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'reservation_date' => $this->input('reservationDate'),
            'customer_id' => $this->input('customer'),
            'table_id' => $this->input('table'),
            'user_id' => $this->input('owner'),
        ]);
    }

    public function attributes(): array {
        return [
            'reservation_date' => 'reservationDate',
            'customer_id' => 'customer',
            'table_id' => 'table',
            'user_id' => 'owner',
        ];
    }
}
