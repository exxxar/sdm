<?php

namespace Tests\Feature\Http\Controllers;

use App\Device;
use App\DeviceParametersHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DeviceParametersHistoryController
 */
class DeviceParametersHistoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $deviceParametersHistories = DeviceParametersHistory::factory()->count(3)->create();

        $response = $this->get(route('device-parameters-history.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceParametersHistoryController::class,
            'store',
            \App\Http\Requests\DeviceParametersHistoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $device = Device::factory()->create();

        $response = $this->post(route('device-parameters-history.store'), [
            'device_id' => $device->id,
        ]);

        $deviceParametersHistories = DeviceParametersHistory::query()
            ->where('device_id', $device->id)
            ->get();
        $this->assertCount(1, $deviceParametersHistories);
        $deviceParametersHistory = $deviceParametersHistories->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $deviceParametersHistory = DeviceParametersHistory::factory()->create();

        $response = $this->get(route('device-parameters-history.show', $deviceParametersHistory));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeviceParametersHistoryController::class,
            'update',
            \App\Http\Requests\DeviceParametersHistoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $deviceParametersHistory = DeviceParametersHistory::factory()->create();
        $device = Device::factory()->create();

        $response = $this->put(route('device-parameters-history.update', $deviceParametersHistory), [
            'device_id' => $device->id,
        ]);

        $deviceParametersHistory->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($device->id, $deviceParametersHistory->device_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $deviceParametersHistory = DeviceParametersHistory::factory()->create();

        $response = $this->delete(route('device-parameters-history.destroy', $deviceParametersHistory));

        $response->assertNoContent();

        $this->assertDeleted($deviceParametersHistory);
    }
}
