<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Subteam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SubteamRequest;
use Inertia\Inertia;
use Redirect;

class SubteamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Activities/Form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubteamRequest $request, Team $team)
    {
        Gate::forUser(\Auth::user())->authorize("manageSubteam", $team);
        // AddingSubteam::dispatch($user);

        $team->subteams()->create($request->validated());
        return Redirect::route("teams.show", $team);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subteam  $subteam
     * @return \Illuminate\Http\Response
     */
    public function show(Subteam $subteam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subteam  $subteam
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team, Subteam $subteam)
    {
        Gate::forUser(\Auth::user())->authorize("manageSubteam", $team);
        return Inertia::render("Subteam/Form", compact("team", "subteam"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subteam  $subteam
     * @return \Illuminate\Http\Response
     */
    public function update(
        SubteamRequest $request,
        Team $team,
        Subteam $subteam
    ) {
        Gate::forUser(\Auth::user())->authorize("manageSubteam", $team);
        $subteam->update($request->validated());

        return Redirect::route("teams.show", $team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subteam  $subteam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team, Subteam $subteam)
    {
        Gate::forUser(\Auth::user())->authorize("manageSubteam", $team);
        $subteam->delete();
        return Redirect::route("teams.show", $team);
    }
}
