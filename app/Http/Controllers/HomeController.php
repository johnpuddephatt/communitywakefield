<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::all();
        return view("home", compact("locations"));
    }

    public function search(Request $request)
    {
        if ($request->input("category")) {
            return redirect()->route(
                $request->input("category") . ".index",
                Request()->except("category")
            );
        }
        return redirect()->back();
    }

    public function location(Request $request, Location $location)
    {
        if ($request->input("category")) {
            return redirect()->route($request->input("category") . ".index", [
                "location" => $location,
            ]);
        }
        return redirect()
            ->back()
            ->with("message", "Search failed. Please try again.");
    }
}
