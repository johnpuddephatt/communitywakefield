<?php

namespace App\Events;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeamMemberRequestReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $team;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Team $team, TeamRequest $teamRequest)
    {
        $this->user = $user;
        $this->team = $team;
        $this->teamRequest = $teamRequest;
    }
}
