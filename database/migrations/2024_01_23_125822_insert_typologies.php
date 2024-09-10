<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define the typologies data
        $typologies = [
            ['name' => 'E-commerce'],
            ['name' => 'Travel agency'],
            ['name' => 'Food delivery socials'],
            ['name' => 'Real estate agency'],
        ];

        // Insert the records into the Typology table
        foreach ($typologies as $typology) {
            \DB::table('typologies')->insert($typology);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
