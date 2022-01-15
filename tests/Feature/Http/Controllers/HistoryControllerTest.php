<?php

namespace Tests\Feature\Http\Controllers;

use App\History;
use App\Object;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HistoryController
 */
class HistoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $histories = History::factory()->count(3)->create();

        $response = $this->get(route('history.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\HistoryController::class,
            'store',
            \App\Http\Requests\HistoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $user = User::factory()->create();
        $type = $this->faker->numberBetween(-10000, 10000);
        $object = Object::factory()->create();
        $action = $this->faker->word;

        $response = $this->post(route('history.store'), [
            'user_id' => $user->id,
            'type' => $type,
            'object_id' => $object->id,
            'action' => $action,
        ]);

        $histories = History::query()
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->where('object_id', $object->id)
            ->where('action', $action)
            ->get();
        $this->assertCount(1, $histories);
        $history = $histories->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $history = History::factory()->create();

        $response = $this->get(route('history.show', $history));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\HistoryController::class,
            'update',
            \App\Http\Requests\HistoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $history = History::factory()->create();
        $user = User::factory()->create();
        $type = $this->faker->numberBetween(-10000, 10000);
        $object = Object::factory()->create();
        $action = $this->faker->word;

        $response = $this->put(route('history.update', $history), [
            'user_id' => $user->id,
            'type' => $type,
            'object_id' => $object->id,
            'action' => $action,
        ]);

        $history->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $history->user_id);
        $this->assertEquals($type, $history->type);
        $this->assertEquals($object->id, $history->object_id);
        $this->assertEquals($action, $history->action);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $history = History::factory()->create();

        $response = $this->delete(route('history.destroy', $history));

        $response->assertNoContent();

        $this->assertDeleted($history);
    }
}
