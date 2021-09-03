<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Location;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\EnquiryController;

class ServiceController extends Controller
{
    public function single(Team $team, Service $service)
    {
        return view("single", ["entry" => $service]);
    }

    public function index(Request $request, Location $location = null)
    {
        $entries = Service::published()
            ->postcodeFilter($request->input("postcode"))
            ->teamFilter($request->input("team"))
            ->suitabilityFilter($request->input("suitability"))
            ->locationFilter($location)
            ->categoryFilter($request->input("category"))
            ->orderBy("created_at", "desc")
            ->paginate(config("system.results_per_page"));

        $filters = Service::filters(["postcode", "suitabilities", "team", "categories"]);
        $name = Service::$name;

        return view("index", compact("name", "entries", "location", "filters"));
    }
    public function enquire(Service $entry)
    {
        return view("enquire", compact("entry"));
    }

    public function storeEnquiry(Request $request, Service $entry)
    {
        return EnquiryController::store($entry, [
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "message" => $request->message,
        ]);
    }
}
