<?php

namespace App\Listeners;

use App\Events\TeamCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\TeamCreatedNotification;
use Illuminate\Support\Facades\Notification;

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
        $admins = User::admins()->get();
        Notification::send($admins, new TeamCreatedNotification($event->team, $event->user));
    }
}
