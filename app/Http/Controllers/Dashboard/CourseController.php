<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Category;
use App\Models\Accessibility;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Redirect;

class CourseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize("viewAny", Course::class);

        return Inertia::render("Courses/Index", [
            "courses" => \Auth::user()
                ->currentTeam->courses()
                ->with("subteam:id,name")
                ->get(),
            "permissions" => [
                "canDeleteTeamEntries" => Gate::check(
                    "delete",
                    \Auth::user()->currentTeam
                ),
            ],
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize("create", Course::class);

        return Inertia::render("Courses/Form", [
            "categories" => Category::where("type", "course")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "accessibilities" => Accessibility::orderBy("title")
                ->select("id", "title")
                ->get(),
            "subteams" => \Auth::user()
                ->currentTeam->subteams()
                ->select("id", "name")
                ->get(),
            "team" => \Auth::user()
                ->currentTeam()
                ->select("name", "phone", "email")
                ->first(),
        ]);
    }

    /**
     * @param \App\Http\Requests\CourseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $this->authorize("create", Course::class);

        $course = Course::create(
            array_merge($request->validated(), ["created_by" => \Auth::user()->id])
        );
        $course->categories()->sync($request->categories);
        $course->accessibilities()->sync($request->accessibilities);

        return Redirect::route("course.edit", [
            "course" => $course,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Course $course)
    {
        // return Inertia::render('Courses/Form', [
        //     'course' => $course
        // ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function clone(Course $course)
    {
        $this->authorize("create", $course);

        $course->id = null;
        $course->created_by = null;
        $course->updated_by = null;
        $course->display_until = null;
        $course->created_at = null;
        $course->updated_at = null;

        $course->categories = $course
            ->categories()
            ->allRelatedIds()
            ->toArray();
        $course->accessibilities = $course
            ->accessibilities()
            ->allRelatedIds()
            ->toArray();

        return Inertia::render("Courses/Form", [
            "course" => $course,
            "accessibilities" => Accessibility::orderBy("title")
                ->select("id", "title")
                ->get(),
            "categories" => Category::where("type", "course")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "subteams" => \Auth::user()
                ->currentTeam->subteams()
                ->select("id", "name")
                ->get(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $this->authorize("update", $course);

        $course->categories = $course
            ->categories()
            ->allRelatedIds()
            ->toArray();
        $course->accessibilities = $course
            ->accessibilities()
            ->allRelatedIds()
            ->toArray();

        return Inertia::render("Courses/Form", [
            "course" => $course,
            "accessibilities" => Accessibility::orderBy("title")
                ->select("id", "title")
                ->get(),
            "categories" => Category::where("type", "course")
                ->orWhere("type", null)
                ->orderBy("title")
                ->select("id", "title")
                ->get(),
            "subteams" => \Auth::user()
                ->currentTeam->subteams()
                ->select("id", "name")
                ->get(),
        ]);
    }

    /**
     * @param \App\Http\Requests\CourseRequest $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize("update", $course);

        $course->update($request->validated());
        $course->categories()->sync($request->categories);
        $course->accessibilities()->sync($request->accessibilities);
        $course->update(["updated_by" => \Auth::user()->id]);

        return Redirect::route("course.edit", compact("course"));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Course $course)
    {
        $this->authorize("delete", $course);

        $course->delete();
        return Redirect::route("courses.show");
    }

    public function destroyAll(Request $request, $course_ids)
    {
        $course_ids_array = explode("-", $course_ids);
        $courses_query = Course::whereIn("id", $course_ids_array);

        $courses = $courses_query->get();

        foreach ($courses as $course) {
            $this->authorize("delete", $course);
        }

        $courses_query->delete();

        return Redirect::route("courses.show");
    }
}
