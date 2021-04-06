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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    Route::group(['middleware' => ['auth', 'verified']], function () {

        Route::resource('activity', App\Http\Controllers\ActivityController::class, [
            'names' => [
                'index' => 'activities.show',
            ]
        ])->middleware('team');
        Route::delete('activity/destroyAll/{ids}',  [App\Http\Controllers\ActivityController::class, 'destroyAll'])->name('activities.destroy');

        Route::resource('event', App\Http\Controllers\EventController::class, [
            'names' => [
                'index' => 'events.show',
            ]
        ])->middleware('team');
        Route::delete('activity/destroyAll/{ids}',  [App\Http\Controllers\ActivityController::class, 'destroyAll'])->name('events.destroy');

        Route::resource('service', App\Http\Controllers\ServiceController::class, [
            'names' => [
                'index' => 'services.show',
            ]
        ])->middleware('team');
        Route::delete('service/destroyAll/{ids}',  [App\Http\Controllers\ServiceController::class, 'destroyAll'])->name('services.destroy');

        Route::resource('volunteering', App\Http\Controllers\VolunteeringController::class, [
            'names' => [
                'index' => 'volunteerings.show',
            ]
        ])->middleware('team');
        Route::delete('volunteering/destroyAll/{ids}',  [App\Http\Controllers\VolunteeringController::class, 'destroyAll'])->name('volunteerings.destroy');

        Route::resource('course', App\Http\Controllers\CourseController::class, [
            'names' => [
                'index' => 'courses.show',
            ]
        ])->middleware('team');
        Route::delete('course/destroyAll/{ids}',  [App\Http\Controllers\CourseController::class, 'destroyAll'])->name('courses.destroy');




        Route::post('teams/{team}/subteam/create',  [App\Http\Controllers\SubteamController::class, 'store'])->name('subteam.store');
        Route::delete('teams/{team}/subteams/{subteam}/destroy',  [App\Http\Controllers\SubteamController::class, 'destroy'])->name('subteam.destroy');
        Route::post('teams/{team}/subteams/{subteam}/update',  [App\Http\Controllers\SubteamController::class, 'update'])->name('subteam.update');
        Route::get('teams/{team}/subteams/{subteam}/edit',  [App\Http\Controllers\SubteamController::class, 'edit'])->name('subteam.edit');

        Route::get('team/join', [App\Http\Controllers\TeamController::class, 'join'])->name('teams.join');
        Route::post('team/{team}/request', [App\Http\Controllers\TeamController::class, 'request'])->name('teams.request');
        Route::post('team/{team}/request/{teamRequest}/approve', [App\Http\Controllers\TeamController::class, 'approveRequest'])->name('teams.approveRequest');

        Route::put('user/update-notification-emails', [App\Http\Controllers\NotificationEmailController::class, 'update'])->name('user-notification-emails.update');

    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


// Route::resource('service', App\Http\Controllers\ServiceController::class);
//
// Route::resource('event', App\Http\Controllers\EventController::class);
//
// Route::resource('volunteering-opportunity', App\Http\Controllers\VolunteeringController::class);
//
//
// Route::resource('learning-opportunity', App\Http\Controllers\CourseController::class);
//
// Route::resource('suitability', App\Http\Controllers\SuitabilityController::class);
//
// Route::resource('accessibility', App\Http\Controllers\AccessibilityController::class);
//
// Route::resource('category', App\Http\Controllers\CategoryController::class);
//
// Route::resource('enquiry', App\Http\Controllers\EnquiryController::class)->only('store');
