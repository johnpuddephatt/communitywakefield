<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Suitability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SuitabilityController
 */
class SuitabilityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $suitabilities = Suitability::factory()->count(3)->create();

        $response = $this->get(route('suitability.index'));

        $response->assertOk();
        $response->assertViewIs('suitability.index');
        $response->assertViewHas('suitabilities');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('suitability.create'));

        $response->assertOk();
        $response->assertViewIs('suitability.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuitabilityController::class,
            'store',
            \App\Http\Requests\SuitabilityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;

        $response = $this->post(route('suitability.store'), [
            'title' => $title,
            'slug' => $slug,
        ]);

        $suitabilities = Suitability::query()
            ->where('title', $title)
            ->where('slug', $slug)
            ->get();
        $this->assertCount(1, $suitabilities);
        $suitability = $suitabilities->first();

        $response->assertRedirect(route('suitability.index'));
        $response->assertSessionHas('suitability.id', $suitability->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $suitability = Suitability::factory()->create();

        $response = $this->get(route('suitability.show', $suitability));

        $response->assertOk();
        $response->assertViewIs('suitability.show');
        $response->assertViewHas('suitability');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $suitability = Suitability::factory()->create();

        $response = $this->get(route('suitability.edit', $suitability));

        $response->assertOk();
        $response->assertViewIs('suitability.edit');
        $response->assertViewHas('suitability');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuitabilityController::class,
            'update',
            \App\Http\Requests\SuitabilityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $suitability = Suitability::factory()->create();
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;

        $response = $this->put(route('suitability.update', $suitability), [
            'title' => $title,
            'slug' => $slug,
        ]);

        $suitability->refresh();

        $response->assertRedirect(route('suitability.index'));
        $response->assertSessionHas('suitability.id', $suitability->id);

        $this->assertEquals($title, $suitability->title);
        $this->assertEquals($slug, $suitability->slug);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $suitability = Suitability::factory()->create();

        $response = $this->delete(route('suitability.destroy', $suitability));

        $response->assertRedirect(route('suitability.index'));

        $this->assertDeleted($suitability);
    }
}
