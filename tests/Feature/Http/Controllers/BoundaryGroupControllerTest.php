<?php

namespace Tests\Feature\Http\Controllers;

use App\BoundaryGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BoundaryGroupController
 */
class BoundaryGroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $boundaryGroups = BoundaryGroup::factory()->count(3)->create();

        $response = $this->get(route('boundary-group.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BoundaryGroupController::class,
            'store',
            \App\Http\Requests\BoundaryGroupStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->post(route('boundary-group.store'), [
            'title' => $title,
            'description' => $description,
        ]);

        $boundaryGroups = BoundaryGroup::query()
            ->where('title', $title)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $boundaryGroups);
        $boundaryGroup = $boundaryGroups->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $boundaryGroup = BoundaryGroup::factory()->create();

        $response = $this->get(route('boundary-group.show', $boundaryGroup));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BoundaryGroupController::class,
            'update',
            \App\Http\Requests\BoundaryGroupUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $boundaryGroup = BoundaryGroup::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->put(route('boundary-group.update', $boundaryGroup), [
            'title' => $title,
            'description' => $description,
        ]);

        $boundaryGroup->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $boundaryGroup->title);
        $this->assertEquals($description, $boundaryGroup->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $boundaryGroup = BoundaryGroup::factory()->create();

        $response = $this->delete(route('boundary-group.destroy', $boundaryGroup));

        $response->assertNoContent();

        $this->assertDeleted($boundaryGroup);
    }
}
