<?php

namespace Database\Factories;

use App\Models\Subteam;
use App\Models\Team;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubteamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subteam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'team_id' => Team::factory()
        ];
    }
}
