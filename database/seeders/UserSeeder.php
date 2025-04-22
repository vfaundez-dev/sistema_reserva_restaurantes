<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    
    public function run(): void {

        // Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@reservation.com',
            'password' => Hash::make('asdf1234'),
        ]);
        $admin->assignRole('administrator');

        // Manager
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@reservation.com',
            'password' => Hash::make('asdf1234'),
        ]);
        $manager->assignRole('manager');

        // Receptionist
        $receptionist = User::create([
            'name' => 'Receptionist',
            'email' => 'receptionist@reservation.com',
            'password' => Hash::make('asdf1234'),
        ]);
        $receptionist->assignRole('receptionist');

        // Waiter
        $waiter = User::create([
            'name' => 'Waiter',
            'email' => 'waiter@reservation.com',
            'password' => Hash::make('asdf1234'),
        ]);
        $waiter->assignRole('waiter');

    }
}
