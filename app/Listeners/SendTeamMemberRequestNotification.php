<?php

namespace App\Listeners;

use App\Events\TeamMemberRequestReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
