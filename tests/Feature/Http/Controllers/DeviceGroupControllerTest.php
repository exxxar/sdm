<?php

namespace Tests\Feature\Http\Controllers;

use App\DeviceGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DeviceGroupController
 */
class DeviceGroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $deviceGroups = DeviceGroup::factory()->count(3)->create();

        $response = $this->get(route('device-group.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceGroupController::class,
            'store',
            \App\Http\Requests\DeviceGroupStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('device-group.store'), [
            'title' => $title,
        ]);

        $deviceGroups = DeviceGroup::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $deviceGroups);
        $deviceGroup = $deviceGroups->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $deviceGroup = DeviceGroup::factory()->create();

        $response = $this->get(route('device-group.show', $deviceGroup));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceGroupController::class,
            'update',
            \App\Http\Requests\DeviceGroupUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $deviceGroup = DeviceGroup::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('device-group.update', $deviceGroup), [
            'title' => $title,
        ]);

        $deviceGroup->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $deviceGroup->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $deviceGroup = DeviceGroup::factory()->create();

        $response = $this->delete(route('device-group.destroy', $deviceGroup));

        $response->assertNoContent();

        $this->assertDeleted($deviceGroup);
    }
}
