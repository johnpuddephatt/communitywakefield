<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ServiceSuitability;

class ServiceSuitabilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceSuitability::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(1),
            'slug' => substr($this->faker->slug,-12),
            'icon' => $this->faker->text,
            'image' => $this->faker->word,
            'colour' => $this->faker->hexcolor
        ];
    }
}
