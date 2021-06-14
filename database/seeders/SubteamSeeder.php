<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subteam;

class SubteamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subteam::factory()->count(25)->create();
    }
}
