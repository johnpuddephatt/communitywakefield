<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Location;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\EnquiryController;

class ActivityController extends Controller
{
    public function single(Team $team, Activity $activity)
    {
        return view("single", ["entry" => $activity]);
    }

    public function index(Request $request, Location $location = null)
    {
        $entries = Activity::published()
            ->postcodeFilter($request->input("postcode"))
            ->teamFilter($request->input("team"))
            ->locationFilter($location)
            ->categoryFilter($request->input("category"))
            ->orderBy("created_at", "desc")
            ->with("team")
            ->paginate(config("system.results_per_page"));

        $filters = Activity::filters(["postcode", "team", "categories"]);
        $name = Activity::$name;

        return view("index", compact("name", "entries", "location", "filters"));
    }

    public function enquire(Activity $entry)
    {
        return view("enquire", compact("entry"));
    }

    public function storeEnquiry(Request $request, Activity $entry)
    {
        return EnquiryController::store($entry, [
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "message" => $request->message,
            "website" => $request->website,
        ]);
    }
}
