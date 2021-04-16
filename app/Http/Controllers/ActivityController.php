<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Accessibility;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Redirect;

class ActivityController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Activity::class);

        return Inertia::render('Activities/Index', [
            'activities' => \Auth::user()->currentTeam->activities()->with('subteam:id,name')->get()
        ]);;

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Activity::class);

        return Inertia::render('Activities/Form', [
            'categories' => Category::where('type', 'activity')->orWhere('type', null)->select('id','title')->get(),
            'accessibilities' => Accessibility::select('id','title')->get(),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get(),
            'team' => \Auth::user()->currentTeam()->select('name','phone','email')->first()
        ]);
    }

    /**
     * @param \App\Http\Requests\ActivityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        $this->authorize('create', Activity::class);

        $activity = Activity::create(array_merge($request->validated(), ['created_by' => \Auth::user()->id]));
        $activity->categories()->sync($request->categories);
        $activity->accessibilities()->sync($request->accessibilities);

        return Redirect::route('activity.edit', [
            'activity' => $activity
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Activity $activity)
    {
        // return Inertia::render('Activities/Form', [
        //     'activity' => $activity
        // ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        $this->authorize('update', $activity);

        $activity->categories = $activity->categories()->allRelatedIds()->toArray();
        $activity->accessibilities = $activity->accessibilities()->allRelatedIds()->toArray();

        return Inertia::render('Activities/Form', [
            'activity' => $activity,
            'categories' => Category::where('type', 'activity')->orWhere('type', null)->select('id','title')->get(),
            'accessibilities' => Accessibility::select('id','title')->get(),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get()
        ]);
    }

    /**
     * @param \App\Http\Requests\ActivityRequest $request
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        $activity->update($request->validated());
        $activity->categories()->sync($request->categories);
        $activity->accessibilities()->sync($request->accessibilities);
        $activity->update(['updated_by' => \Auth::user()->id]);

        return Redirect::route('activity.edit', compact('activity'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Activity $activity)
    {
        $this->authorize('delete', $activity);

        $activity->delete();
        return Redirect::route('activities.show');
    }

    public function destroyAll(Request $request, $activity_ids)
    {
        $activity_ids_array = explode('-', $activity_ids);
        $activities_query = Activity::whereIn('id', $activity_ids_array);

        $activities = $activities_query->get();

        foreach($activities as $activity) {
            $this->authorize('delete', $activity);
        }

        $activities_query->delete();

        return Redirect::route('activities.show');
    }
}
