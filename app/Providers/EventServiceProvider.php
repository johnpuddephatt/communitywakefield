<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;

use App\Events\TeamMemberRequestReceived;
use App\Events\TeamMemberAutojoined;
use App\Events\TeamMemberRequestApproved;
use App\Events\TeamCreated;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\SendTeamMemberRequestNotification;
use App\Listeners\SendTeamMemberAutojoinedNotification;
use App\Listeners\SendTeamMemberRequestApprovedNotification;
use App\Listeners\SendTeamCreatedNotification;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        TeamMemberRequestReceived::class => [
            SendTeamMemberRequestNotification::class,
        ],

        TeamMemberAutojoined::class => [
            SendTeamMemberAutojoinedNotification::class,
        ],

        TeamMemberRequestApproved::class => [
            SendTeamMemberRequestApprovedNotification::class,
        ],

        TeamCreated::class => [
            SendTeamCreatedNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
