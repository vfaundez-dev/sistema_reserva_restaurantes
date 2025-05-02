<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource {
    
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'reservation_date' => $this->reservation_date->format('Y-m-d'),
            'reservation_time' => $this->reservation_time,
            'number_of_peoples' => $this->number_of_peoples,
            'status' => $this->status,
            'status' => $this->status,
            'notes' => $this->notes,
            'customer' => new CustomerResource( $this->whenLoaded('customer') ),
            'user' => new UserResource( $this->whenLoaded('user') ),
            'tables' => TableResource::collection( $this->whenLoaded('tables') )
        ];
    }
}
