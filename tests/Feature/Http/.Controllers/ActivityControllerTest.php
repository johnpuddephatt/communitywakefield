<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Activity;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ActivityController
 */
class ActivityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $activities = Activity::factory()->count(3)->create();

        $response = $this->get(route('activity.index'));

        $response->assertOk();
        $response->assertViewIs('activity.index');
        $response->assertViewHas('activities');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('activity.create'));

        $response->assertOk();
        $response->assertViewIs('activity.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActivityController::class,
            'store',
            \App\Http\Requests\ActivityStoreRequest::class
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
        $address_ward = $this->faker->word;

        $response = $this->post(route('activity.store'), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'address_ward' => $address_ward,
        ]);

        $activities = Activity::query()
            ->where('team_id', $team->id)
            ->where('last_reviewed', $last_reviewed)
            ->where('status', $status)
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('content', $content)
            ->where('address_ward', $address_ward)
            ->get();
        $this->assertCount(1, $activities);
        $activity = $activities->first();

        $response->assertRedirect(route('activity.index'));
        $response->assertSessionHas('activity.id', $activity->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $activity = Activity::factory()->create();

        $response = $this->get(route('activity.show', $activity));

        $response->assertOk();
        $response->assertViewIs('activity.show');
        $response->assertViewHas('activity');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $activity = Activity::factory()->create();

        $response = $this->get(route('activity.edit', $activity));

        $response->assertOk();
        $response->assertViewIs('activity.edit');
        $response->assertViewHas('activity');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActivityController::class,
            'update',
            \App\Http\Requests\ActivityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $activity = Activity::factory()->create();
        $team = Team::factory()->create();
        $last_reviewed = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $address_ward = $this->faker->word;

        $response = $this->put(route('activity.update', $activity), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'address_ward' => $address_ward,
        ]);

        $activity->refresh();

        $response->assertRedirect(route('activity.index'));
        $response->assertSessionHas('activity.id', $activity->id);

        $this->assertEquals($team->id, $activity->team_id);
        $this->assertEquals(Carbon::parse($last_reviewed), $activity->last_reviewed);
        $this->assertEquals($status, $activity->status);
        $this->assertEquals($title, $activity->title);
        $this->assertEquals($slug, $activity->slug);
        $this->assertEquals($content, $activity->content);
        $this->assertEquals($address_ward, $activity->address_ward);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $activity = Activity::factory()->create();

        $response = $this->delete(route('activity.destroy', $activity));

        $response->assertRedirect(route('activity.index'));

        $this->assertSoftDeleted($activity);
    }
}
