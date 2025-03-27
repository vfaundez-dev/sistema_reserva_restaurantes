<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory {
    
    public function definition(): array {
        $lastTableNumber = Table::max('table_number') ?? 0;

        return [
            'table_number' => $lastTableNumber + 1,
            'capacity' => $this->faker->numberBetween(2, 8),
            'location' => $this->faker->randomElement(['indoor', 'outdoor']),
        ];
    }
}
