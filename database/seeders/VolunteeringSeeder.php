<?php

namespace Database\Seeders;

use App\Models\Volunteering;
use Illuminate\Database\Seeder;

class VolunteeringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Volunteering::factory()->count(5)->create();
    }
}
