<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends FormRequest {
    
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'reservation_date' => ['sometimes', 'required', 'date', 'after_or_equal:today'],
            'status' => ['sometimes', 'string', 'in:pending,confirmed,cancelled'],
            'notes' => ['sometimes', 'required', 'string', 'max:255'],
            'customer_id' => ['sometimes', 'required', 'exists:customers,id'],
            'table_id' => ['sometimes', 'required', 'exists:tables,id',
                Rule::exists('tables', 'id')->where(function ($query) {
                    $query->where('is_available', true);
                })
            ],
            'user_id' => ['sometimes', 'required', 'exists:users,id'],
        ];
    }

    protected function prepareForValidation() {
        collect([
            'reservationDate' => 'reservation_date',
            'customer' => 'customer_id',
            'table' => 'table_id',
            'owner' => 'user_id'
        ])->each(function ($attribute, $key) {
            if ($this->has($key)) {
                $this->merge( [$attribute => $this->input($key)] );
            }
        });
    }

    public function attributes(): array {
        return [
            'reservation_date' => 'reservationDate',
            'customer_id' => 'customer',
            'table_id' => 'table',
            'user_id' => 'owner',
        ];
    }

    public function messages() {
        return [
            'table_id.exists' => 'The selected table is not available.',
        ];
    }
    
}
