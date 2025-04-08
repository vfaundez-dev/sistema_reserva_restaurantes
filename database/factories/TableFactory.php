<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory {
    
    public function definition(): array {
        return [
            'is_available' => true,
            'capacity' => $this->faker->numberBetween(2, 8),
            'location' => $this->faker->randomElement(['indoor', 'outdoor']),
        ];
    }
}
