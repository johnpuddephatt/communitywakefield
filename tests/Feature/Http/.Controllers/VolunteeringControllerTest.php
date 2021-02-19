<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Team;
use App\Models\Volunteering;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VolunteeringController
 */
class VolunteeringControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $volunteeringOpportunities = Volunteering::factory()->count(3)->create();

        $response = $this->get(route('volunteering-opportunity.index'));

        $response->assertOk();
        $response->assertViewIs('volunteeringOpportunity.index');
        $response->assertViewHas('volunteeringOpportunities');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('volunteering-opportunity.create'));

        $response->assertOk();
        $response->assertViewIs('volunteeringOpportunity.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VolunteeringController::class,
            'store',
            \App\Http\Requests\VolunteeringStoreRequest::class
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
        $frequency = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('volunteering-opportunity.store'), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'from_home' => $from_home,
            'address_ward' => $address_ward,
            'frequency' => $frequency,
        ]);

        $volunteeringOpportunities = Volunteering::query()
            ->where('team_id', $team->id)
            ->where('last_reviewed', $last_reviewed)
            ->where('status', $status)
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('content', $content)
            ->where('from_home', $from_home)
            ->where('address_ward', $address_ward)
            ->where('frequency', $frequency)
            ->get();
        $this->assertCount(1, $volunteeringOpportunities);
        $volunteeringOpportunity = $volunteeringOpportunities->first();

        $response->assertRedirect(route('volunteeringOpportunity.index'));
        $response->assertSessionHas('volunteeringOpportunity.id', $volunteeringOpportunity->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $volunteeringOpportunity = Volunteering::factory()->create();

        $response = $this->get(route('volunteering-opportunity.show', $volunteeringOpportunity));

        $response->assertOk();
        $response->assertViewIs('volunteeringOpportunity.show');
        $response->assertViewHas('volunteeringOpportunity');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $volunteeringOpportunity = Volunteering::factory()->create();

        $response = $this->get(route('volunteering-opportunity.edit', $volunteeringOpportunity));

        $response->assertOk();
        $response->assertViewIs('volunteeringOpportunity.edit');
        $response->assertViewHas('volunteeringOpportunity');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VolunteeringController::class,
            'update',
            \App\Http\Requests\VolunteeringUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $volunteeringOpportunity = Volunteering::factory()->create();
        $team = Team::factory()->create();
        $last_reviewed = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $from_home = $this->faker->boolean;
        $address_ward = $this->faker->word;
        $frequency = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('volunteering-opportunity.update', $volunteeringOpportunity), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'from_home' => $from_home,
            'address_ward' => $address_ward,
            'frequency' => $frequency,
        ]);

        $volunteeringOpportunity->refresh();

        $response->assertRedirect(route('volunteeringOpportunity.index'));
        $response->assertSessionHas('volunteeringOpportunity.id', $volunteeringOpportunity->id);

        $this->assertEquals($team->id, $volunteeringOpportunity->team_id);
        $this->assertEquals(Carbon::parse($last_reviewed), $volunteeringOpportunity->last_reviewed);
        $this->assertEquals($status, $volunteeringOpportunity->status);
        $this->assertEquals($title, $volunteeringOpportunity->title);
        $this->assertEquals($slug, $volunteeringOpportunity->slug);
        $this->assertEquals($content, $volunteeringOpportunity->content);
        $this->assertEquals($from_home, $volunteeringOpportunity->from_home);
        $this->assertEquals($address_ward, $volunteeringOpportunity->address_ward);
        $this->assertEquals($frequency, $volunteeringOpportunity->frequency);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $volunteeringOpportunity = Volunteering::factory()->create();

        $response = $this->delete(route('volunteering-opportunity.destroy', $volunteeringOpportunity));

        $response->assertRedirect(route('volunteeringOpportunity.index'));

        $this->assertSoftDeleted($volunteeringOpportunity);
    }
}
