<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Activity;
use App\Models\Service;
use App\Models\Course;
use App\Models\Volunteering;
use App\Models\Team;
use App\Policies\TeamPolicy;
use App\Policies\ActivityPolicy;
use App\Policies\ServicePolicy;
use App\Policies\EventPolicy;
use App\Policies\CoursePolicy;
use App\Policies\VolunteeringPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Activity::class => ActivityPolicy::class,
        Service::class => ServicePolicy::class,
        Event::class => EventPolicy::class,
        Course::class => CoursePolicy::class,
        Volunteering::class => VolunteeringPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
