<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource {
    
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'reservationDate' => $this->reservation_date->format('Y-m-d'),
            'reservationTime' => $this->reservation_time,
            'numberOfPeoples' => $this->number_of_peoples,
            'status' => $this->status,
            'status' => $this->status,
            'notes' => $this->notes,
            'customer' => new CustomerResource( $this->customer ),
            'owner' => new UserResource( $this->user ),
            'tables' => TableResource::collection( $this->tables ),
        ];
    }
}
