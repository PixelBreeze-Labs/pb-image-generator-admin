<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create permissions
         Permission::firstOrCreate(['name'=>'create-an-admin']);
         Permission::firstOrCreate(['name'=>'edit-an-admin']);
         Permission::firstOrCreate(['name'=>'delete-an-admin']);
         // Create roles
         $superadmin = Role::firstOrCreate(['name'=>'superadmin']);
         $admin = Role::firstOrCreate(['name'=>'admin']);
         // Give permission to certain role
         $superadmin->givePermissionTo(['create-an-admin', 'edit-an-admin', 'delete-an-admin']);
    }
}
