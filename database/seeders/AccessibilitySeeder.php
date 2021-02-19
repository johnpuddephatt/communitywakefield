<?php

namespace Database\Seeders;

use App\Models\Accessibility;
use Illuminate\Database\Seeder;

class AccessibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accessibility::factory()->count(5)->create();
    }
}
