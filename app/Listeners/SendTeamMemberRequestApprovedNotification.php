<?php

namespace App\Listeners;

use App\Events\TeamMemberRequestApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\TeamMemberRequestApprovedNotification;

class SendTeamMemberRequestApprovedNotification
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
     * @param  TeamMemberRequestApproved  $event
     * @return void
     */
    public function handle(TeamMemberRequestApproved $event)
    {
       $event->user->notify(new TeamMemberRequestApprovedNotification($event->team));
    }
}
