<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Accessibility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccessibilityController
 */
class AccessibilityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $accessibilities = Accessibility::factory()->count(3)->create();

        $response = $this->get(route('accessibility.index'));

        $response->assertOk();
        $response->assertViewIs('accessibility.index');
        $response->assertViewHas('accessibilities');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('accessibility.create'));

        $response->assertOk();
        $response->assertViewIs('accessibility.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccessibilityController::class,
            'store',
            \App\Http\Requests\AccessibilityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;

        $response = $this->post(route('accessibility.store'), [
            'title' => $title,
            'slug' => $slug,
        ]);

        $accessibilities = Accessibility::query()
            ->where('title', $title)
            ->where('slug', $slug)
            ->get();
        $this->assertCount(1, $accessibilities);
        $accessibility = $accessibilities->first();

        $response->assertRedirect(route('accessibility.index'));
        $response->assertSessionHas('accessibility.id', $accessibility->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $accessibility = Accessibility::factory()->create();

        $response = $this->get(route('accessibility.show', $accessibility));

        $response->assertOk();
        $response->assertViewIs('accessibility.show');
        $response->assertViewHas('accessibility');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $accessibility = Accessibility::factory()->create();

        $response = $this->get(route('accessibility.edit', $accessibility));

        $response->assertOk();
        $response->assertViewIs('accessibility.edit');
        $response->assertViewHas('accessibility');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccessibilityController::class,
            'update',
            \App\Http\Requests\AccessibilityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $accessibility = Accessibility::factory()->create();
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;

        $response = $this->put(route('accessibility.update', $accessibility), [
            'title' => $title,
            'slug' => $slug,
        ]);

        $accessibility->refresh();

        $response->assertRedirect(route('accessibility.index'));
        $response->assertSessionHas('accessibility.id', $accessibility->id);

        $this->assertEquals($title, $accessibility->title);
        $this->assertEquals($slug, $accessibility->slug);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $accessibility = Accessibility::factory()->create();

        $response = $this->delete(route('accessibility.destroy', $accessibility));

        $response->assertRedirect(route('accessibility.index'));

        $this->assertDeleted($accessibility);
    }
}
