<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Device;
use App\DeviceParametersHistory;

class DeviceParametersHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeviceParametersHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'device_id' => Device::factory(),
            'violations' => $this->faker->numberBetween(-10000, 10000),
            'passages' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->word,
            'ping' => $this->faker->numberBetween(-10000, 10000),
            'voltage' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
