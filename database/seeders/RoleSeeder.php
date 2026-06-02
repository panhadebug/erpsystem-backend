<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full system access and control',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Department and team management',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Regular employee access',
            ],
            [
                'name' => 'Viewer',
                'slug' => 'viewer',
                'description' => 'Read-only access',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}

// Assign role
$user->roles()->attach($adminRole);

// Check role
$user->hasRole('admin');

// Check multiple roles
$user->hasAnyRole(['admin', 'manager']);
