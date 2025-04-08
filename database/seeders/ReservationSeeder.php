<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder {
    
    public function run(): void {

        Reservation::factory()
            ->count(10)
            ->state(['status' => 'completed'])
            ->create();
            
        Reservation::factory()
            ->count(5)
            ->state(['status' => 'canceled'])
            ->create();
        
        Reservation::factory()
            ->count(5)
            ->state(['status' => 'pending'])
            ->create();
            
        Reservation::factory()
            ->count(5)
            ->state(['status' => 'confirmed'])
            ->create();
        
    }
}
