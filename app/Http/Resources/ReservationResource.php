<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource {
    
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'reservationDate' => $this->reservation_date->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'notes' => $this->notes,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
            'customer' => new CustomerResource($this->customer),
            'tables' => new TableResource($this->table),
            'owner' => $this->user_id,
        ];
    }
}
