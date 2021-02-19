<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Course;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CourseController
 */
class CourseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $learningOpportunities = Courses::factory()->count(3)->create();

        $response = $this->get(route('learning-opportunity.index'));

        $response->assertOk();
        $response->assertViewIs('course.index');
        $response->assertViewHas('learningOpportunities');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('learning-opportunity.create'));

        $response->assertOk();
        $response->assertViewIs('course.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourseController::class,
            'store',
            \App\Http\Requests\CoursesStoreRequest::class
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

        $response = $this->post(route('learning-opportunity.store'), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'from_home' => $from_home,
            'address_ward' => $address_ward,
        ]);

        $learningOpportunities = Courses::query()
            ->where('team_id', $team->id)
            ->where('last_reviewed', $last_reviewed)
            ->where('status', $status)
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('content', $content)
            ->where('from_home', $from_home)
            ->where('address_ward', $address_ward)
            ->get();
        $this->assertCount(1, $learningOpportunities);
        $course = $learningOpportunities->first();

        $response->assertRedirect(route('course.index'));
        $response->assertSessionHas('course.id', $course->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $course = Courses::factory()->create();

        $response = $this->get(route('learning-opportunity.show', $course));

        $response->assertOk();
        $response->assertViewIs('course.show');
        $response->assertViewHas('course');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $course = Courses::factory()->create();

        $response = $this->get(route('learning-opportunity.edit', $course));

        $response->assertOk();
        $response->assertViewIs('course.edit');
        $response->assertViewHas('course');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourseController::class,
            'update',
            \App\Http\Requests\CoursesUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $course = Courses::factory()->create();
        $team = Team::factory()->create();
        $last_reviewed = $this->faker->date();
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug;
        $content = $this->faker->paragraphs(3, true);
        $from_home = $this->faker->boolean;
        $address_ward = $this->faker->word;

        $response = $this->put(route('learning-opportunity.update', $course), [
            'team_id' => $team->id,
            'last_reviewed' => $last_reviewed,
            'status' => $status,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'from_home' => $from_home,
            'address_ward' => $address_ward,
        ]);

        $course->refresh();

        $response->assertRedirect(route('course.index'));
        $response->assertSessionHas('course.id', $course->id);

        $this->assertEquals($team->id, $course->team_id);
        $this->assertEquals(Carbon::parse($last_reviewed), $course->last_reviewed);
        $this->assertEquals($status, $course->status);
        $this->assertEquals($title, $course->title);
        $this->assertEquals($slug, $course->slug);
        $this->assertEquals($content, $course->content);
        $this->assertEquals($from_home, $course->from_home);
        $this->assertEquals($address_ward, $course->address_ward);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $course = Courses::factory()->create();

        $response = $this->delete(route('learning-opportunity.destroy', $course));

        $response->assertRedirect(route('course.index'));

        $this->assertSoftDeleted($course);
    }
}
