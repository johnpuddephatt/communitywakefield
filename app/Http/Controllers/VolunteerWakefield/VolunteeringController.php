<?php

namespace App\Http\Controllers\VolunteerWakefield;

use App\Http\Controllers\Controller as Controller;

use App\Http\Requests\VolunteeringRequest;
use App\Models\Volunteering;
use App\Models\Team;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use GuzzleHttp\Client;

use Redirect;

class VolunteeringController extends Controller
{
    public function single(Team $team, Volunteering $volunteering)
    {
        return view("single", ["entry" => $volunteering]);
    }

    public function index(Request $request, Location $location = null)
    {
        $entries = Volunteering::postcodeFilter($request->input("postcode"))
            ->teamFilter($request->input("team"))
            ->categoryFilter($request->input("category"))
            ->suitabilityFilter($request->input("suitability"))
            ->locationFilter($location)
            ->orderBy("created_at", "desc")
            ->with("team")
            ->paginate(config("system.results_per_page"));

        $filters = Volunteering::filters(["postcode", "team", "categories"]);
        $name = Volunteering::$name;

        return view("index", compact("name", "entries", "location", "filters"));
    }

    public function enquire(Volunteering $entry)
    {
        return view("enquire", compact("entry"));
    }
}
