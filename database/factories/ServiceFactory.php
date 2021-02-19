<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\Team;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

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
            'directions' => $this->faker->sentence(12),
            'times' => $this->faker->sentence(8),
            'minimum_age' => $this->faker->numberBetween(5, 21),
            'maximum_age' => $this->faker->numberBetween(12, 100),
            'cost' => $this->faker->randomElement(["","Free if in receipt of universal credit, otherwise £4 per session","£2","£7","£12"]),
            'what_to_bring' => $this->faker->sentence(12),
            'booking_link' => $this->faker->word,
            'booking_instructions' => $this->faker->sentence(10),
        ];
    }
}
