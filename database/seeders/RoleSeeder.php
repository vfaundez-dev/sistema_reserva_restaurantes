<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
    
    public function run(): void {
        $roles = [
            ['name' => 'administrator'],
            ['name' => 'manager'],
            ['name' => 'receptionist'],
            ['name' => 'waiter'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
