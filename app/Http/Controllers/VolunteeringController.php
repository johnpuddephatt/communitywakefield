<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteeringRequest;
use App\Models\Volunteering;
use Illuminate\Http\Request;

class VolunteeringController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $volunteering = Volunteering::all();

        return view('volunteering.index', compact('volunteering'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('volunteering.create');
    }

    /**
     * @param \App\Http\Requests\VolunteeringRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteeringRequest $request)
    {
        $volunteering = Volunteering::create($request->validated());

        $request->session()->flash('volunteering.id', $volunteering->id);

        return redirect()->route('volunteering.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Volunteering $volunteeringOpportunity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Volunteering $volunteering)
    {
        return view('volunteering.show', compact('volunteering'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Volunteering $volunteeringOpportunity
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Volunteering $volunteering)
    {
        return view('volunteering.edit', compact('volunteering'));
    }

    /**
     * @param \App\Http\Requests\VolunteeringRequest $request
     * @param \App\Models\Volunteering $volunteeringOpportunity
     * @return \Illuminate\Http\Response
     */
    public function update(VolunteeringRequest $request, Volunteering $volunteering)
    {
        $volunteering->update($request->validated());

        $request->session()->flash('volunteering.id', $volunteering->id);

        return redirect()->route('volunteering.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Volunteering $volunteeringOpportunity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Volunteering $volunteering)
    {
        $volunteering->delete();

        return redirect()->route('volunteering.index');
    }
}
