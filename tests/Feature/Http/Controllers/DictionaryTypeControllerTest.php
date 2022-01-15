<?php

namespace Tests\Feature\Http\Controllers;

use App\DictionaryType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DictionaryTypeController
 */
class DictionaryTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $dictionary_types = DictionaryType::factory()->count(3)->create();

        $response = $this->get(route('dictionary-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DictionaryTypeController::class,
            'store',
            \App\Http\Requests\DictionaryTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);

        $response = $this->post(route('dictionary-type.store'), [
            'title' => $title,
        ]);

        $dictionary_types = DictionaryType::query()
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $dictionary_types);
        $dictionary_type = $dictionary_types->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $dictionary_type = DictionaryType::factory()->create();

        $response = $this->get(route('dictionary-type.show', $dictionary_type));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DictionaryTypeController::class,
            'update',
            \App\Http\Requests\DictionaryTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $dictionary_type = DictionaryType::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('dictionary-type.update', $dictionary_type), [
            'title' => $title,
        ]);

        $dictionary_type->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $dictionary_type->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $dictionary_type = DictionaryType::factory()->create();

        $response = $this->delete(route('dictionary-type.destroy', $dictionary_type));

        $response->assertNoContent();

        $this->assertDeleted($dictionary_type);
    }
}
