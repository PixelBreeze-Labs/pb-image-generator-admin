<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Iconstyle',
            'domain' => 'https://iconstyle.al',
            'email' => 'info@iconstyle.al',
            'typology' => '1',
            'admin_id' => "2",
        ]);

        Company::create([
            'name' => 'Electral shpk',
            'domain' => 'https://gazetareforma.com',
            'email' => 'gazetareformaweb@gmail.com',
            'typology' => '5',
            'admin_id' => "3",
        ]);
    }
}
