<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteeringRequest;
use App\Models\Volunteering;
use App\Models\Category;
use App\Models\Accessibility;
use App\Models\VolunteeringSuitability;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Redirect;

class VolunteeringController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Volunteering::class);

        return Inertia::render('Volunteering/Index', [
            'volunteerings' => \Auth::user()->currentTeam->volunteerings()->with('subteam:id,name')->get()
        ]);;

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Volunteering::class);

        return Inertia::render('Volunteering/Form', [
            'categories' => Category::select('id','title')->get(),
            'accessibilities' => Accessibility::select('id','title')->get(),
            'suitabilities' => VolunteeringSuitability::select('id','title')->get(),
            'requirements' => config('system.requirements'),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get(),
            'team' => \Auth::user()->currentTeam()->select('name','phone','email')->first()
        ]);
    }

    /**
     * @param \App\Http\Requests\VolunteeringRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteeringRequest $request)
    {
        $this->authorize('create', Volunteering::class);

        $volunteering = Volunteering::create(array_merge($request->validated(), ['created_by' => \Auth::user()->id]));
        $volunteering->categories()->sync($request->categories);
        $volunteering->accessibilities()->sync($request->accessibilities);
        $volunteering->suitabilities()->sync($request->suitabilities);

        return Redirect::route('volunteering.edit', [
            'volunteering' => $volunteering
        ]);

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Volunteering $volunteering
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Volunteering $volunteering)
    {
        // return Inertia::render('Volunteering/Form', [
        //     'volunteering' => $volunteering
        // ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Volunteering $volunteering
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteering $volunteering)
    {
        $this->authorize('update', $volunteering);

        $volunteering->categories = $volunteering->categories()->allRelatedIds()->toArray();
        $volunteering->accessibilities = $volunteering->accessibilities()->allRelatedIds()->toArray();
        $volunteering->suitabilities = $volunteering->suitabilities()->allRelatedIds()->toArray();

        return Inertia::render('Volunteering/Form', [
            'volunteering' => $volunteering,
            'categories' => Category::select('id','title')->get(),
            'accessibilities' => Accessibility::select('id','title')->get(),
            'suitabilities' => VolunteeringSuitability::select('id','title')->get(),
            'requirements' => config('system.requirements'),
            'skills' => config('system.skills'),
            'subteams' => \Auth::user()->currentTeam->subteams()->select('id','name')->get()
        ]);
    }

    /**
     * @param \App\Http\Requests\VolunteeringRequest $request
     * @param \App\Models\Volunteering $volunteering
     * @return \Illuminate\Http\Response
     */
    public function update(VolunteeringRequest $request, Volunteering $volunteering)
    {
        $this->authorize('update', $volunteering);

        $volunteering->update($request->validated());
        $volunteering->categories()->sync($request->categories);
        $volunteering->accessibilities()->sync($request->accessibilities);
        $volunteering->suitabilities()->sync($request->suitabilitiesx);
        $volunteering->update(['updated_by' => \Auth::user()->id]);

        return Redirect::route('volunteering.edit', compact('volunteering'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Volunteering $volunteering
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Volunteering $volunteering)
    {
        $this->authorize('delete', $volunteering);

        $volunteering->delete();
        return Redirect::route('volunteerings.show');
    }

    public function destroyAll(Request $request, $volunteering_ids)
    {
        $volunteering_ids_array = explode('-', $volunteering_ids);
        $volunteerings_query = Volunteering::whereIn('id', $volunteering_ids_array);

        $volunteerings = $volunteerings_query->get();

        foreach($volunteerings as $volunteering) {
            $this->authorize('delete', $volunteering);
        }

        $volunteerings_query->delete();

        return Redirect::route('volunteerings.show');
    }
}
