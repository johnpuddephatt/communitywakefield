<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\EnquiryController;

class EventController extends Controller
{
    public function single(Team $team, Event $event)
    {
        return view("single", ["entry" => $event]);
    }

    public function index(Request $request, Location $location = null)
    {
        $entries = Event::published()
            ->postcodeFilter($request->input("postcode"))
            ->teamFilter($request->input("team"))
            ->categoryFilter($request->input("category"))
            ->locationFilter($location)
            ->where("start_date", ">=", Carbon::now()->toDateTimeString())
            ->orderBy("start_date", "asc")
            ->with("team")
            ->paginate(config("system.results_per_page"));

        $filters = Event::filters(["postcode", "team", "categories"]);
        $name = Event::$name;

        return view("index", compact("name", "location", "entries", "filters"));
    }

    public function enquire(Event $entry)
    {
        return view("enquire", compact("entry"));
    }

    public function storeEnquiry(Request $request, Event $entry)
    {
        return EnquiryController::store($entry, [
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "message" => $request->message,
        ]);
    }
}
