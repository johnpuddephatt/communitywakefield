<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'activity' => 'App\Models\Activity',
            'course' => 'App\Models\Course',
            'event' => 'App\Models\Event',
            'service' => 'App\Models\Service',
            'volunteering' => 'App\Models\Volunteering'
        ]);
    }
}
