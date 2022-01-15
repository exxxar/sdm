<?php

namespace Tests\Feature\Http\Controllers;

use App\Dictionary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DictionaryController
 */
class DictionaryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $dictionaries = Dictionary::factory()->count(3)->create();

        $response = $this->get(route('dictionary.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DictionaryController::class,
            'store',
            \App\Http\Requests\DictionaryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $dictionary_type_id = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('dictionary.store'), [
            'title' => $title,
            'dictionary_type_id' => $dictionary_type_id,
        ]);

        $dictionaries = Dictionary::query()
            ->where('title', $title)
            ->where('dictionary_type_id', $dictionary_type_id)
            ->get();
        $this->assertCount(1, $dictionaries);
        $dictionary = $dictionaries->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $dictionary = Dictionary::factory()->create();

        $response = $this->get(route('dictionary.show', $dictionary));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DictionaryController::class,
            'update',
            \App\Http\Requests\DictionaryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $dictionary = Dictionary::factory()->create();
        $title = $this->faker->sentence(4);
        $dictionary_type_id = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('dictionary.update', $dictionary), [
            'title' => $title,
            'dictionary_type_id' => $dictionary_type_id,
        ]);

        $dictionary->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $dictionary->title);
        $this->assertEquals($dictionary_type_id, $dictionary->dictionary_type_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $dictionary = Dictionary::factory()->create();

        $response = $this->delete(route('dictionary.destroy', $dictionary));

        $response->assertNoContent();

        $this->assertDeleted($dictionary);
    }
}
