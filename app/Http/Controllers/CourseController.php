<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\EnquiryController;

class CourseController extends Controller
{
    public function single(Course $entry)
    {
        return view("single", compact("entry"));
    }

    public function index(Request $request, Location $location = null)
    {
        $entries = Course::published()
            ->postcodeFilter($request->input("postcode"))
            ->teamFilter($request->input("team"))
            ->categoryFilter($request->input("category"))
            ->locationFilter($location)
            ->orderBy("created_at", "desc")
            ->paginate(config("system.results_per_page"));

        $filters = Course::filters(["postcode", "team", "categories"]);
        $name = Course::$name;

        return view("index", compact("name", "entries", "location", "filters"));
    }

    public function enquire(Course $entry)
    {
        return view("enquire", compact("entry"));
    }

    public function storeEnquiry(Request $request, Course $entry)
    {
        return EnquiryController::store($entry, [
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "message" => $request->message,
        ]);
    }
}
