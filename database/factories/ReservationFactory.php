<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory {
    
    public function definition(): array {

        $availableTable = Table::whereDoesntHave('reservations', function ($query) {
            $query->whereIn('status', ['pending', 'confirmed']);
        })->where('is_available', true)
          ->inRandomOrder()
          ->first();

        $status = $this->faker->randomElement(['pending', 'confirmed', 'canceled']);

        if (!$availableTable) {
            $status = 'canceled';
            $availableTable = Table::inRandomOrder()->first();
        } else {
            $availableTable->update(['is_available' => false]);
        }

        return [
            'reservation_date' => $this->faker->dateTimeBetween(now(), '+1 month'),
            'status' => $status,
            'notes' => $this->faker->text(),
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'table_id' => $availableTable->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
