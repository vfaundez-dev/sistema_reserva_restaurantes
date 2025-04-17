<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource {
    
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'registrationDate' => $this->registration_date->format('Y-m-d H:i:s'),
            'reservations' => ReservationResource::collection( $this->whenLoaded('reservations') )
        ];
    }
}
