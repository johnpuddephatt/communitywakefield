<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Service;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceController
 */
class ServiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $services = Service::factory()->count(3)->create();

        $response = $this->get(route('service.index'));

        $response->assertOk();
        $response->assertViewIs('service.index');
        $response->assertViewHas('services');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('service.create'));

        $response->assertOk();
        $response->assertViewIs('service.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'store',
            \App\Http\Requests\ServiceStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $team = Team::factory()->create();
        $last_reviewed = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $from_home = $this->faker->boolean;
        $address_ward = $this->faker->word;

        $response = $this->post(route('service.store'), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'from_home' => $from_home,
            'address_ward' => $address_ward,
        ]);

        $services = Service::query()
            ->where('team_id', $team->id)
            ->where('last_reviewed', $last_reviewed)
            ->where('status', $status)
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('content', $content)
            ->where('from_home', $from_home)
            ->where('address_ward', $address_ward)
            ->get();
        $this->assertCount(1, $services);
        $service = $services->first();

        $response->assertRedirect(route('service.index'));
        $response->assertSessionHas('service.id', $service->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $service = Service::factory()->create();

        $response = $this->get(route('service.show', $service));

        $response->assertOk();
        $response->assertViewIs('service.show');
        $response->assertViewHas('service');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $service = Service::factory()->create();

        $response = $this->get(route('service.edit', $service));

        $response->assertOk();
        $response->assertViewIs('service.edit');
        $response->assertViewHas('service');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'update',
            \App\Http\Requests\ServiceUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $service = Service::factory()->create();
        $team = Team::factory()->create();
        $last_reviewed = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $from_home = $this->faker->boolean;
        $address_ward = $this->faker->word;

        $response = $this->put(route('service.update', $service), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'from_home' => $from_home,
            'address_ward' => $address_ward,
        ]);

        $service->refresh();

        $response->assertRedirect(route('service.index'));
        $response->assertSessionHas('service.id', $service->id);

        $this->assertEquals($team->id, $service->team_id);
        $this->assertEquals(Carbon::parse($last_reviewed), $service->last_reviewed);
        $this->assertEquals($status, $service->status);
        $this->assertEquals($title, $service->title);
        $this->assertEquals($slug, $service->slug);
        $this->assertEquals($content, $service->content);
        $this->assertEquals($from_home, $service->from_home);
        $this->assertEquals($address_ward, $service->address_ward);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $service = Service::factory()->create();

        $response = $this->delete(route('service.destroy', $service));

        $response->assertRedirect(route('service.index'));

        $this->assertSoftDeleted($service);
    }
}
