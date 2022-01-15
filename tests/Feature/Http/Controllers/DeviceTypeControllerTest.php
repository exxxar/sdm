<?php

namespace Tests\Feature\Http\Controllers;

use App\DeviceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DeviceTypeController
 */
class DeviceTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $deviceTypes = DeviceType::factory()->count(3)->create();

        $response = $this->get(route('device-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceTypeController::class,
            'store',
            \App\Http\Requests\DeviceTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('device-type.store'), [
            'title' => $title,
        ]);

        $deviceTypes = DeviceType::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $deviceTypes);
        $deviceType = $deviceTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $deviceType = DeviceType::factory()->create();

        $response = $this->get(route('device-type.show', $deviceType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceTypeController::class,
            'update',
            \App\Http\Requests\DeviceTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $deviceType = DeviceType::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('device-type.update', $deviceType), [
            'title' => $title,
        ]);

        $deviceType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $deviceType->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $deviceType = DeviceType::factory()->create();

        $response = $this->delete(route('device-type.destroy', $deviceType));

        $response->assertNoContent();

        $this->assertDeleted($deviceType);
    }
}
