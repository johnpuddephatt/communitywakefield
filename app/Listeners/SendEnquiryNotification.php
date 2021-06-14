<?php

namespace App\Listeners;

use App\Events\EnquiryCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\EnquiryNotification;
use Illuminate\Support\Facades\Notification;

class SendEnquiryNotification
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
     * @param  EnquiryCreated  $event
     * @return void
     */
    public function handle(EnquiryCreated $event)
    {
        $users = $event->enquirable->team->allUsers();
        Notification::send(
            $users,
            new EnquiryNotification($event->enquiry, $event->enquirable)
        );
    }
}
