<?php

namespace App\Listeners;

use App\Events\TeamMemberAutojoined;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TeamMemberAutojoinedNotification;

class SendTeamMemberAutojoinedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TeamMemberAutojoined  $event
     * @return void
     */
    public function handle(TeamMemberAutojoined $event)
    {
        $event->team->owner->notify(new TeamMemberAutojoinedNotification($event->team, $event->user));
    }
}
