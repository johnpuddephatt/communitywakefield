<?php

namespace App\Http\Controllers\VolunteerWakefield;
use App\Http\Controllers\Controller as Controller;

use App\Http\Requests\VolunteeringRequest;
use App\Models\Volunteering;
use App\Models\Category;
use App\Models\Accessibility;
use App\Models\Suitability;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Cache;

use Redirect;

class HomeController extends Controller
{
    public function index()
    {
        $opportunities = Cache::remember(
            "home_opportunities",
            86400,
            function () {
                return Volunteering::latest()
                    ->take(5)
                    ->get();
            }
        );
        // $locations =  Cache::rememberForever('home_locations', function () {
        //   return Location::all()->shuffle()->take(3);
        // });
        // $categories = Cache::rememberForever('home_categories', function () {
        //   return Category::withCount('opportunities')->orderBy('opportunities_count', 'desc')->get();
        // });
        // $suitabilities = Cache::rememberForever('home_suitabilities', function () {
        //   return Suitability::withCount('opportunities')->orderBy('opportunities_count', 'desc')->get();
        // });
        return view("volunteering.home", compact("opportunities"));
    }
}
