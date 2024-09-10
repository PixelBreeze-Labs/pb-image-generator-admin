<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@pixelbreeze.com',
            'password' => bcrypt('jW812+Fm'),
        ])->assignRole('superadmin');

        User::create([
            'name' => 'Iconstyle',
            'email' => 'info@iconstyle.al',
            'password' => bcrypt('xQ2L;d99'),
        ])->assignRole('admin');

        User::create([
            'name' => 'Electral shpk',
            'email' => 'gazetareformaweb@gmail.com',
            'password' => bcrypt('M3-2024!!-xy6'),
        ])->assignRole('admin');
    }
}
