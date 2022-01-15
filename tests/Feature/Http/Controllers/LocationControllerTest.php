<?php

namespace Tests\Feature\Http\Controllers;

use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LocationController
 */
class LocationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $locations = Location::factory()->count(3)->create();

        $response = $this->get(route('location.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocationController::class,
            'store',
            \App\Http\Requests\LocationStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->post(route('location.store'), [
            'title' => $title,
            'description' => $description,
        ]);

        $locations = Location::query()
            ->where('title', $title)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $locations);
        $location = $locations->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $location = Location::factory()->create();

        $response = $this->get(route('location.show', $location));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocationController::class,
            'update',
            \App\Http\Requests\LocationUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $location = Location::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->put(route('location.update', $location), [
            'title' => $title,
            'description' => $description,
        ]);

        $location->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $location->title);
        $this->assertEquals($description, $location->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $location = Location::factory()->create();

        $response = $this->delete(route('location.destroy', $location));

        $response->assertNoContent();

        $this->assertDeleted($location);
    }
}
