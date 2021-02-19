<?php

namespace Database\Seeders;

use App\Models\ServiceSuitability;
use Illuminate\Database\Seeder;

class ServiceSuitabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceSuitability::factory()->count(5)->create();
    }
}
