<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    
    public function run(): void {
        $users = [
            [
                'name' => 'Administrador',
                'email' => 'admin@reservation.com',
                'password' => Hash::make('asdf1234'),
                'role_id' => 1,
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@reservation.com',
                'password' => Hash::make('asdf1234'),
                'role_id' => 2,
            ],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@reservation.com',
                'password' => Hash::make('asdf1234'),
                'role_id' => 3,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
