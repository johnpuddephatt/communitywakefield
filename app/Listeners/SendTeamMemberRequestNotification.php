<?php

namespace App\Listeners;

use App\Events\TeamMemberRequestReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\TeamMemberRequestNotification;

class SendTeamMemberRequestNotification
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
     * @param  TeamMemberRequestReceived  $event
     * @return void
     */
    public function handle(TeamMemberRequestReceived $event)
    {
        $event->team->owner->notify(new TeamMemberRequestNotification($event->team, $event->user, $event->teamRequest));
    }
}
