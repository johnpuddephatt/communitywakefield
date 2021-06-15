<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(config("system.volunteerwakefield_url"))->group(function () {
    Route::get("/", [
        App\Http\Controllers\VolunteerWakefield\HomeController::class,
        "index",
    ])->name("volunteering.home");
    Route::get("opportunities/{location:slug?}", [
        App\Http\Controllers\VolunteerWakefield\VolunteeringController::class,
        "index",
    ])->name("opportunities.index");

    Route::get("opportunity/{entry:slug}", [
        App\Http\Controllers\VolunteerWakefield\VolunteeringController::class,
        "single",
    ])->name("opportunities.single");

    Route::get("opportunity/{entry:slug}/enquire", [
        App\Http\Controllers\VolunteerWakefield\VolunteeringController::class,
        "enquire",
    ])->name("opportunities.enquire");

    Route::post("opportunity/{entry:slug}/enquire", [
        App\Http\Controllers\VolunteerWakefield\VolunteeringController::class,
        "storeEnquiry",
    ])->name("opportunities.enquire.store");
});

Route::domain(config("system.communitywakefield_url"))->group(function () {
    Route::get("/", [App\Http\Controllers\HomeController::class, "index"])->name("home");

    Route::get("about", function () {
        return view("about");
    })->name("about");

    Route::get("search", [App\Http\Controllers\HomeController::class, "search"])->name(
        "home.search"
    );

    Route::post("location/{location:slug}", [
        App\Http\Controllers\HomeController::class,
        "location",
    ])->name("home.location");

    Route::get("activities/{location:slug?}", [
        App\Http\Controllers\ActivityController::class,
        "index",
    ])->name("activities.index");
    Route::get("activity/{entry:slug}", [
        App\Http\Controllers\ActivityController::class,
        "single",
    ])->name("activities.single");
    Route::get("activity/{entry:slug}/enquire", [
        App\Http\Controllers\ActivityController::class,
        "enquire",
    ])->name("activities.enquire");
    Route::post("activity/{entry:slug}/enquire", [
        App\Http\Controllers\ActivityController::class,
        "storeEnquiry",
    ])->name("activities.enquire.store");

    Route::get("services/{location:slug?}", [
        App\Http\Controllers\ServiceController::class,
        "index",
    ])->name("services.index");
    Route::get("service/{entry:slug}", [
        App\Http\Controllers\ServiceController::class,
        "single",
    ])->name("services.single");
    Route::get("service/{entry:slug}/enquire", [
        App\Http\Controllers\ServiceController::class,
        "enquire",
    ])->name("services.enquire");
    Route::post("service/{entry:slug}/enquire", [
        App\Http\Controllers\ServiceController::class,
        "storeEnquiry",
    ])->name("services.enquire.store");

    Route::get("events/{location:slug?}", [
        App\Http\Controllers\EventController::class,
        "index",
    ])->name("events.index");
    Route::get("/event/{entry:slug}", [
        App\Http\Controllers\EventController::class,
        "single",
    ])->name("events.single");
    Route::get("/event/{entry:slug}/enquire", [
        App\Http\Controllers\EventController::class,
        "enquire",
    ])->name("events.enquire");
    Route::post("/event/{entry:slug}/enquire", [
        App\Http\Controllers\EventController::class,
        "storeEnquiry",
    ])->name("events.enquire.store");

    Route::get("courses/{location:slug?}", [
        App\Http\Controllers\CourseController::class,
        "index",
    ])->name("courses.index");
    Route::get("course/{entry:slug}", [
        App\Http\Controllers\CourseController::class,
        "single",
    ])->name("courses.single");
    Route::get("course/{entry:slug}/enquire", [
        App\Http\Controllers\CourseController::class,
        "enquire",
    ])->name("courses.enquire");
    Route::post("course/{entry:slug}/enquire", [
        App\Http\Controllers\CourseController::class,
        "storeEnquiry",
    ])->name("courses.enquire.store");

    Route::middleware(["auth:sanctum", "verified"])
        ->get("/dashboard", function () {
            return Inertia::render("Dashboard");
        })
        ->name("dashboard");

    Route::group(
        [
            "prefix" => "dashboard",
            "middleware" => config("jetstream.middleware", ["web", "verified"]),
        ],
        function () {
            Route::group(["middleware" => ["auth", "verified"]], function () {
                Route::resource(
                    "activity",
                    App\Http\Controllers\Dashboard\ActivityController::class,
                    [
                        "names" => [
                            "index" => "activities.show",
                        ],
                    ]
                )->middleware("team");
                Route::delete("activity/destroyAll/{ids}", [
                    App\Http\Controllers\Dashboard\ActivityController::class,
                    "destroyAll",
                ])->name("activities.destroy");

                Route::resource(
                    "event",
                    App\Http\Controllers\Dashboard\EventController::class,
                    [
                        "names" => [
                            "index" => "events.show",
                        ],
                    ]
                )->middleware("team");
                Route::delete("activity/destroyAll/{ids}", [
                    App\Http\Controllers\Dashboard\ActivityController::class,
                    "destroyAll",
                ])->name("events.destroy");

                Route::resource(
                    "service",
                    App\Http\Controllers\Dashboard\ServiceController::class,
                    [
                        "names" => [
                            "index" => "services.show",
                        ],
                    ]
                )->middleware("team");
                Route::delete("service/destroyAll/{ids}", [
                    App\Http\Controllers\Dashboard\ServiceController::class,
                    "destroyAll",
                ])->name("services.destroy");

                Route::resource(
                    "volunteering",
                    App\Http\Controllers\Dashboard\VolunteeringController::class,
                    [
                        "names" => [
                            "index" => "volunteerings.show",
                        ],
                    ]
                )->middleware("team");
                Route::delete("volunteering/destroyAll/{ids}", [
                    App\Http\Controllers\Dashboard\VolunteeringController::class,
                    "destroyAll",
                ])->name("volunteerings.destroy");

                Route::resource(
                    "course",
                    App\Http\Controllers\Dashboard\CourseController::class,
                    [
                        "names" => [
                            "index" => "courses.show",
                        ],
                    ]
                )->middleware("team");
                Route::delete("course/destroyAll/{ids}", [
                    App\Http\Controllers\Dashboard\CourseController::class,
                    "destroyAll",
                ])->name("courses.destroy");

                Route::post("teams/{team}/subteam/create", [
                    App\Http\Controllers\SubteamController::class,
                    "store",
                ])->name("subteam.store");
                Route::delete("teams/{team}/subteams/{subteam}/destroy", [
                    App\Http\Controllers\SubteamController::class,
                    "destroy",
                ])->name("subteam.destroy");
                Route::put("teams/{team}/subteams/{subteam}/update", [
                    App\Http\Controllers\SubteamController::class,
                    "update",
                ])->name("subteam.update");
                Route::get("teams/{team}/subteams/{subteam}/edit", [
                    App\Http\Controllers\SubteamController::class,
                    "edit",
                ])->name("subteam.edit");

                Route::get("team/join", [
                    App\Http\Controllers\TeamController::class,
                    "join",
                ])->name("teams.join");
                Route::post("team/{team}/request", [
                    App\Http\Controllers\TeamController::class,
                    "request",
                ])->name("teams.request");

                Route::post("team/{team}/request/{teamRequest}/approve", [
                    App\Http\Controllers\TeamController::class,
                    "approveRequest",
                ])->name("teams.approveRequest");
                Route::get("team/{team}/request/{teamRequest}/approve", [
                    App\Http\Controllers\TeamController::class,
                    "approveRequest",
                ])->name("teams.approveRequestGet");

                Route::put("user/update-notification-emails", [
                    App\Http\Controllers\NotificationEmailController::class,
                    "update",
                ])->name("user-notification-emails.update");
            });
        }
    );
});
