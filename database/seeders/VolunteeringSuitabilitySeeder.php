<?php

namespace Database\Seeders;

use App\Models\VolunteeringSuitability;
use Illuminate\Database\Seeder;

class VolunteeringSuitabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VolunteeringSuitability::factory()->count(5)->create();
    }
}
