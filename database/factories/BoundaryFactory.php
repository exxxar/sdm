<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Boundary;
use App\Region;

class BoundaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Boundary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'region_id' => Region::factory(),
            'is_active' => $this->faker->boolean,
            'deleted_at' => $this->faker->dateTime(),
            'mobile' => $this->faker->boolean,
            'lat' => $this->faker->latitude,
            'lon' => $this->faker->word,
            'moving' => $this->faker->boolean,
            'coords' => $this->faker->word,
            'speed_mode' => $this->faker->word,
        ];
    }
}
