<?php

namespace Tests\Feature\Http\Controllers;

use App\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RegionController
 */
class RegionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $regions = Region::factory()->count(3)->create();

        $response = $this->get(route('region.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'store',
            \App\Http\Requests\RegionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('region.store'), [
            'title' => $title,
        ]);

        $regions = Region::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $regions);
        $region = $regions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $region = Region::factory()->create();

        $response = $this->get(route('region.show', $region));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'update',
            \App\Http\Requests\RegionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $region = Region::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('region.update', $region), [
            'title' => $title,
        ]);

        $region->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $region->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $region = Region::factory()->create();

        $response = $this->delete(route('region.destroy', $region));

        $response->assertNoContent();

        $this->assertDeleted($region);
    }
}
