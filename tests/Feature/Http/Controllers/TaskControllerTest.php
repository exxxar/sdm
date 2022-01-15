<?php

namespace Tests\Feature\Http\Controllers;

use App\DeviceBoundary;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TaskController
 */
class TaskControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get(route('task.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'store',
            \App\Http\Requests\TaskStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $status = $this->faker->word;
        $user = User::factory()->create();
        $device_boundary = DeviceBoundary::factory()->create();

        $response = $this->post(route('task.store'), [
            'status' => $status,
            'user_id' => $user->id,
            'device_boundary_id' => $device_boundary->id,
        ]);

        $tasks = Task::query()
            ->where('status', $status)
            ->where('user_id', $user->id)
            ->where('device_boundary_id', $device_boundary->id)
            ->get();
        $this->assertCount(1, $tasks);
        $task = $tasks->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('task.show', $task));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'update',
            \App\Http\Requests\TaskUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $task = Task::factory()->create();
        $status = $this->faker->word;
        $user = User::factory()->create();
        $device_boundary = DeviceBoundary::factory()->create();

        $response = $this->put(route('task.update', $task), [
            'status' => $status,
            'user_id' => $user->id,
            'device_boundary_id' => $device_boundary->id,
        ]);

        $task->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($status, $task->status);
        $this->assertEquals($user->id, $task->user_id);
        $this->assertEquals($device_boundary->id, $task->device_boundary_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('task.destroy', $task));

        $response->assertNoContent();

        $this->assertDeleted($task);
    }
}
