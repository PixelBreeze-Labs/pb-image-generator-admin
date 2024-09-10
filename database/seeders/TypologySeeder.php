<?php

namespace Database\Seeders;

use App\Models\Typology;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Typology::create(['name' => 'Digital media']);
        Typology::create(['name' => 'Showbiz media company']);
        Typology::create(['name' => 'Broadcast Media']);
        Typology::create(['name' => 'Social Media']);
        Typology::create(['name' => 'Digital media, Actuality, Political']);
    }
}
