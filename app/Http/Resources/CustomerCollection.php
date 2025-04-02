<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection {
    
    public function toArray(Request $request): array {
        return [
            'status' => true,
            'data' => CustomerResource::collection($this->collection)
        ];
    }
}
