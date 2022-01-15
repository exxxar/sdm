<?php

namespace Tests\Feature\Http\Controllers;

use App\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TaskStatusController
 */
class TaskStatusControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $taskStatuses = TaskStatus::factory()->count(3)->create();

        $response = $this->get(route('task-status.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskStatusController::class,
            'store',
            \App\Http\Requests\TaskStatusStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('task-status.store'), [
            'title' => $title,
        ]);

        $taskStatuses = TaskStatus::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $taskStatuses);
        $taskStatus = $taskStatuses->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->get(route('task-status.show', $taskStatus));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskStatusController::class,
            'update',
            \App\Http\Requests\TaskStatusUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $taskStatus = TaskStatus::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('task-status.update', $taskStatus), [
            'title' => $title,
        ]);

        $taskStatus->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $taskStatus->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->delete(route('task-status.destroy', $taskStatus));

        $response->assertNoContent();

        $this->assertDeleted($taskStatus);
    }
}
