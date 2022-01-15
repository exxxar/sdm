<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Boundary;
use App\Device;
use App\DeviceType;
use App\Region;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serial' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'device_type_id' => DeviceType::factory(),
            'deleted_at' => $this->faker->dateTime(),
            'properties' => '{}',
            'region_id' => Region::factory(),
            'last_poll_at' => $this->faker->dateTime(),
            'device_boundary_id' => Boundary::factory(),
            'mobile' => $this->faker->boolean,
        ];
    }
}
