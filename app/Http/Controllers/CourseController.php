<?php

namespace App\Http\Controllers;

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
        $this->authorize('viewAny', Course::class);

        return Inertia::render('Courses/Index', [
            'courses' => \Auth::user()->currentTeam->courses()->with('subteam:id,name')->get()
        ]);;

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Course::class);

        return Inertia::render('Courses/Form', [
            'categories' => Category::where('type', 'course')->orWhere('type', null)->select('id','title')->get(),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get(),
            'team' => \Auth::user()->currentTeam()->select('name','phone','email')->first()
        ]);
    }

    /**
     * @param \App\Http\Requests\CourseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $course = Course::create(array_merge($request->validated(), ['created_by' => \Auth::user()->id]));
        $course->categories()->sync($request->categories);

        return Redirect::route('course.edit', [
            'course' => $course
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
    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $course->categories = $course->categories()->allRelatedIds()->toArray();

        return Inertia::render('Courses/Form', [
            'course' => $course,
            'categories' => Category::where('type', 'course')->orWhere('type', null)->select('id','title')->get(),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get()
        ]);
    }

    /**
     * @param \App\Http\Requests\CourseRequest $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course->update($request->validated());
        $course->categories()->sync($request->categories);
        $course->update(['updated_by' => \Auth::user()->id]);

        return Redirect::route('course.edit', compact('course'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();
        return Redirect::route('courses.show');
    }

    public function destroyAll(Request $request, $course_ids)
    {
        $course_ids_array = explode('-', $course_ids);
        $courses_query = Course::whereIn('id', $course_ids_array);

        $courses = $courses_query->get();

        foreach($courses as $course) {
            $this->authorize('delete', $course);
        }

        $courses_query->delete();

        return Redirect::route('courses.show');
    }
}
