<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run(): void {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            TableSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
