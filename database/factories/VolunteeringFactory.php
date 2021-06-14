<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Team;
use App\Models\Volunteering;

class VolunteeringFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Volunteering::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'display_until' => $this->faker->date(),
            'status' => $this->faker->randomElement(["Published","Draft"]),
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraphs(3, true),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'from_home' => $this->faker->boolean,
            'address' => $this->faker->address,
            'address_ward' => $this->faker->word,
            'postcode' => $this->faker->word,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'directions' => $this->faker->sentence(10),
            'places' => $this->faker->numberBetween(-10000, 10000),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'frequency' => $this->faker->randomElement(["One-off","Fixed period","Ongoing"]),
            'hours' => $this->faker->numberBetween(0, 12),
            'deadline' => $this->faker->date(),
            'minimum_age' => $this->faker->numberBetween(5, 18),
            'maximum_age' => $this->faker->numberBetween(18, 100),
            'expenses' => $this->faker->sentence(12),
            'what_to_bring' => $this->faker->sentence(12),
            'requirements' => '{}',
            'skills_needed' => '{}',
            'skills_gained' => '{}',
        ];
    }
}
