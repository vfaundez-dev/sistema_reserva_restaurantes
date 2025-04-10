<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory {
    
    public function definition(): array {

        $status = $this->faker->randomElement(['pending', 'confirmed', 'completed', 'canceled']);
        $date = $this->faker->dateTimeBetween(now(), '+1 week');
        $time = $time = \Carbon\Carbon::createFromTime(
                    $this->faker->numberBetween(11, 22), // Hours
                    $this->faker->numberBetween(0, 59)   // Minutes
                )->format('H:i'); // 11:00 to 22:00 hrs

        return [
            'reservation_date' => $date->format('Y-m-d'),
            'reservation_time' => $time,
            'number_of_peoples' => $this->faker->numberBetween(1, 8),
            'status' => $status,
            'notes' => $this->faker->paragraph(1),
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];

    }

    public function configure() {
        return $this->afterCreating(function (Reservation $reservation) {

            $tablesCount = $this->faker->numberBetween(1, 2); // Only one or two tables for a reservation
            $tables = collect();

            // We get two tables for reservation
            if ($reservation->id <= 10) {
                $tables = Table::inRandomOrder()->limit($tablesCount)->get();
            } else {

                // For other reservations (11 to 15)
                $tables = Table::where('capacity', '>=', $reservation->number_of_peoples)
                    ->where('is_available', true)
                    ->inRandomOrder()
                    ->limit($tablesCount)
                    ->get();

                // Update table availability if the reservation is pending or confirmed
                if ( in_array($reservation->status, ['pending', 'confirmed']) ) {
                    $tables->each(function ($table) {
                        $table->update(['is_available' => false]);
                    });
                }

            }

            // Attach the tables to the reservation
            $reservation->tables()->attach($tables);

        });
    }

}
