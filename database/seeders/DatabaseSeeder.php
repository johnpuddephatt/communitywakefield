<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // CourseSeeder::class,
            // ServiceSeeder::class,
            // ServiceSuitabilitySeeder::class,
            // VolunteeringSuitabilitySeeder::class,
            // VolunteeringSeeder::class,
            // EventSeeder::class,
            // EnquirySeeder::class,
            CategorySeeder::class,
            ActivitySeeder::class,
            AccessibilitySeeder::class,

            // SubteamSeeder::class
        ]);
    }
}
