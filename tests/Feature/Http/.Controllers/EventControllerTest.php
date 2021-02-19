<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 */
class EventControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $events = Event::factory()->count(3)->create();

        $response = $this->get(route('event.index'));

        $response->assertOk();
        $response->assertViewIs('event.index');
        $response->assertViewHas('events');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('event.create'));

        $response->assertOk();
        $response->assertViewIs('event.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'store',
            \App\Http\Requests\EventStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $team = Team::factory()->create();
        $start date = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $address_ward = $this->faker->word;

        $response = $this->post(route('event.store'), [
            'team_id' => $team->id,
            'start date' => $start date,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'address_ward' => $address_ward,
        ]);

        $events = Event::query()
            ->where('team_id', $team->id)
            ->where('start date', $start date)
            ->where('status', $status)
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('content', $content)
            ->where('address_ward', $address_ward)
            ->get();
        $this->assertCount(1, $events);
        $event = $events->first();

        $response->assertRedirect(route('event.index'));
        $response->assertSessionHas('event.id', $event->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('event.show', $event));

        $response->assertOk();
        $response->assertViewIs('event.show');
        $response->assertViewHas('event');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('event.edit', $event));

        $response->assertOk();
        $response->assertViewIs('event.edit');
        $response->assertViewHas('event');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'update',
            \App\Http\Requests\EventUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $event = Event::factory()->create();
        $team = Team::factory()->create();
        $start date = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $address_ward = $this->faker->word;

        $response = $this->put(route('event.update', $event), [
            'team_id' => $team->id,
            'start date' => $start date,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'address_ward' => $address_ward,
        ]);

        $event->refresh();

        $response->assertRedirect(route('event.index'));
        $response->assertSessionHas('event.id', $event->id);

        $this->assertEquals($team->id, $event->team_id);
        $this->assertEquals(Carbon::parse($start date), $event->start date);
        $this->assertEquals($status, $event->status);
        $this->assertEquals($title, $event->title);
        $this->assertEquals($slug, $event->slug);
        $this->assertEquals($content, $event->content);
        $this->assertEquals($address_ward, $event->address_ward);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $event = Event::factory()->create();

        $response = $this->delete(route('event.destroy', $event));

        $response->assertRedirect(route('event.index'));

        $this->assertSoftDeleted($event);
    }
}
