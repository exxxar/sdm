<?php

namespace Tests\Feature\Http\Controllers;

use App\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DeviceController
 */
class DeviceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $devices = Device::factory()->count(3)->create();

        $response = $this->get(route('device.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceController::class,
            'store',
            \App\Http\Requests\DeviceStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $serial = $this->faker->word;
        $is_active = $this->faker->boolean;
        $properties = $this->faker->;
        $mobile = $this->faker->boolean;

        $response = $this->post(route('device.store'), [
            'serial' => $serial,
            'is_active' => $is_active,
            'properties' => $properties,
            'mobile' => $mobile,
        ]);

        $devices = Device::query()
            ->where('serial', $serial)
            ->where('is_active', $is_active)
            ->where('properties', $properties)
            ->where('mobile', $mobile)
            ->get();
        $this->assertCount(1, $devices);
        $device = $devices->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $device = Device::factory()->create();

        $response = $this->get(route('device.show', $device));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceController::class,
            'update',
            \App\Http\Requests\DeviceUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $device = Device::factory()->create();
        $serial = $this->faker->word;
        $is_active = $this->faker->boolean;
        $properties = $this->faker->;
        $mobile = $this->faker->boolean;

        $response = $this->put(route('device.update', $device), [
            'serial' => $serial,
            'is_active' => $is_active,
            'properties' => $properties,
            'mobile' => $mobile,
        ]);

        $device->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($serial, $device->serial);
        $this->assertEquals($is_active, $device->is_active);
        $this->assertEquals($properties, $device->properties);
        $this->assertEquals($mobile, $device->mobile);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $device = Device::factory()->create();

        $response = $this->delete(route('device.destroy', $device));

        $response->assertNoContent();

        $this->assertDeleted($device);
    }
}
