<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource {

    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'isAvailable' => $this->is_available,
            'capacity' => $this->capacity,
            'location' => $this->location,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
