<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuitabilityRequest;
use App\Models\Suitability;
use Illuminate\Http\Request;

class SuitabilityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suitabilities = Suitability::all();

        return view('suitability.index', compact('suitabilities'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('suitability.create');
    }

    /**
     * @param \App\Http\Requests\SuitabilityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuitabilityRequest $request)
    {
        $suitability = Suitability::create($request->validated());

        $request->session()->flash('suitability.id', $suitability->id);

        return redirect()->route('suitability.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Suitability $suitability
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Suitability $suitability)
    {
        return view('suitability.show', compact('suitability'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Suitability $suitability
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Suitability $suitability)
    {
        return view('suitability.edit', compact('suitability'));
    }

    /**
     * @param \App\Http\Requests\SuitabilityRequest $request
     * @param \App\Models\Suitability $suitability
     * @return \Illuminate\Http\Response
     */
    public function update(SuitabilityRequest $request, Suitability $suitability)
    {
        $suitability->update($request->validated());

        $request->session()->flash('suitability.id', $suitability->id);

        return redirect()->route('suitability.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Suitability $suitability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Suitability $suitability)
    {
        $suitability->delete();

        return redirect()->route('suitability.index');
    }
}
