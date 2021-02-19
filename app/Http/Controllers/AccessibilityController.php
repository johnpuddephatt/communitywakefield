<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessibilityRequest;
use App\Models\Accessibility;
use Illuminate\Http\Request;

class AccessibilityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accessibilities = Accessibility::all();

        return view('accessibility.index', compact('accessibilities'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('accessibility.create');
    }

    /**
     * @param \App\Http\Requests\AccessibilityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccessibilityRequest $request)
    {
        $accessibility = Accessibility::create($request->validated());

        $request->session()->flash('accessibility.id', $accessibility->id);

        return redirect()->route('accessibility.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Accessibility $accessibility
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Accessibility $accessibility)
    {
        return view('accessibility.show', compact('accessibility'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Accessibility $accessibility
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Accessibility $accessibility)
    {
        return view('accessibility.edit', compact('accessibility'));
    }

    /**
     * @param \App\Http\Requests\AccessibilityRequest $request
     * @param \App\Models\Accessibility $accessibility
     * @return \Illuminate\Http\Response
     */
    public function update(AccessibilityRequest $request, Accessibility $accessibility)
    {
        $accessibility->update($request->validated());

        $request->session()->flash('accessibility.id', $accessibility->id);

        return redirect()->route('accessibility.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Accessibility $accessibility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Accessibility $accessibility)
    {
        $accessibility->delete();

        return redirect()->route('accessibility.index');
    }
}
