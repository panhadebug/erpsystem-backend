<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'product.view'],
            ['name' => 'product.create'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],
            ['name' => 'supplier.view'],
            ['name' => 'purchase.view'],
            ['name' => 'dashboard.view'],
        ]);
    }
}
