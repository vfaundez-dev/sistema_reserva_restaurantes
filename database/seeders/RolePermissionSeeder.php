<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder {
    
    public function run(): void {
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions

        $permissions = [
            // Customers
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            
            // Tables
            'view tables',
            'create tables',
            'edit tables',
            'delete tables',
            'release tables',
            'occupy tables',
            'view available tables',
            
            // Reservations
            'view reservations',
            'create reservations',
            'edit reservations',
            'delete reservations',
            'complete reservations',
            'cancel reservations',
            
            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',
            'change user password',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles

        $admin = Role::create(['name' => 'administrator']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            // Customers
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            
            // Tables
            'view tables',
            'create tables',
            'edit tables',
            'delete tables',
            'release tables',
            'occupy tables',
            'view available tables',
            
            // Reservations
            'view reservations',
            'create reservations',
            'edit reservations',
            'delete reservations',
            'complete reservations',
            'cancel reservations',
            
            // Users
            'view users',
            'create users',
        ]);

        $receptionist = Role::create(['name' => 'receptionist']);
        $receptionist->givePermissionTo([
            // Customers
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            
            // Tables
            'view tables',
            'create tables',
            'edit tables',
            'delete tables',
            'release tables',
            'occupy tables',
            'view available tables',
            
            // Reservations
            'view reservations',
            'create reservations',
            'edit reservations',
            'delete reservations',
            'complete reservations',
            'cancel reservations',
        ]);

        $waiter = Role::create(['name' => 'waiter']);
        $waiter->givePermissionTo([
            // Tables
            'view tables',
            'view available tables',
            
            // Reservations
            'view reservations',
            'create reservations',
        ]);

    }
}
