<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Boundary;
use App\Device;
use App\Task;
use App\TaskStatus;
use App\User;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->word,
            'user_id' => User::factory(),
            'device_boundary_id' => Boundary::factory(),
            'device_id' => Device::factory(),
            'date_executed' => $this->faker->dateTime(),
            'note' => $this->faker->word,
            'deleted_at' => $this->faker->dateTime(),
            'task_status_id' => TaskStatus::factory(),
        ];
    }
}
