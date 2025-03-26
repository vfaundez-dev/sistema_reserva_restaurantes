<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory {
    
    public function definition(): array {
        return [
            'reservation_date' => $this->faker->dateTimeBetween(now(), '+1 month'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'canceled']),
            'notes' => $this->faker->text(),
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'table_id' => Table::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
