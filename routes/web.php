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
        ]);
        Route::delete('activity/destroyAll/{ids}',  [App\Http\Controllers\ActivityController::class, 'destroyAll'])->name('activities.destroy');
        Route::post('teams/{team}/subteam/create',  [App\Http\Controllers\SubteamController::class, 'store'])->name('subteam.store');
        Route::delete('teams/{team}/subteam/{subteam}/destroy',  [App\Http\Controllers\SubteamController::class, 'destroy'])->name('subteam.destroy');
        Route::post('teams/{team}/subteam/{subteam}/update',  [App\Http\Controllers\SubteamController::class, 'update'])->name('subteam.update');
        Route::get('teams/{team}/subteam/{subteam}/edit',  [App\Http\Controllers\SubteamController::class, 'edit'])->name('subteam.edit');




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
