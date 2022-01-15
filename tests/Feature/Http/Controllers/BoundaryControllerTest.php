<?php

namespace Tests\Feature\Http\Controllers;

use App\Boundary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BoundaryController
 */
class BoundaryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $boundaries = Boundary::factory()->count(3)->create();

        $response = $this->get(route('boundary.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BoundaryController::class,
            'store',
            \App\Http\Requests\BoundaryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $is_active = $this->faker->boolean;
        $mobile = $this->faker->boolean;
        $moving = $this->faker->boolean;

        $response = $this->post(route('boundary.store'), [
            'title' => $title,
            'is_active' => $is_active,
            'mobile' => $mobile,
            'moving' => $moving,
        ]);

        $boundaries = Boundary::query()
            ->where('title', $title)
            ->where('is_active', $is_active)
            ->where('mobile', $mobile)
            ->where('moving', $moving)
            ->get();
        $this->assertCount(1, $boundaries);
        $boundary = $boundaries->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $boundary = Boundary::factory()->create();

        $response = $this->get(route('boundary.show', $boundary));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BoundaryController::class,
            'update',
            \App\Http\Requests\BoundaryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $boundary = Boundary::factory()->create();
        $title = $this->faker->sentence(4);
        $is_active = $this->faker->boolean;
        $mobile = $this->faker->boolean;
        $moving = $this->faker->boolean;

        $response = $this->put(route('boundary.update', $boundary), [
            'title' => $title,
            'is_active' => $is_active,
            'mobile' => $mobile,
            'moving' => $moving,
        ]);

        $boundary->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $boundary->title);
        $this->assertEquals($is_active, $boundary->is_active);
        $this->assertEquals($mobile, $boundary->mobile);
        $this->assertEquals($moving, $boundary->moving);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $boundary = Boundary::factory()->create();

        $response = $this->delete(route('boundary.destroy', $boundary));

        $response->assertNoContent();

        $this->assertDeleted($boundary);
    }
}
