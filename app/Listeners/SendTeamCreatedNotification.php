<?php

namespace App\Listeners;

use App\Events\TeamCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTeamCreatedNotification
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
     * @param  TeamCreated  $event
     * @return void
     */
    public function handle(TeamCreated $event)
    {
        //
    }
}
