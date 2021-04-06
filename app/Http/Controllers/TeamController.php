<?php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamRequest;
use Illuminate\Http\Request;
use App\Actions\Jetstream\AddTeamMember;
use App\Events\TeamMemberRequestReceived;
use App\Events\TeamMemberRequestApproved;

use Inertia\Inertia;
use Gate;

class TeamController extends Controller
{

    public function join() {
        return Inertia::render('Teams/Join', [
            'teams' => \App\Models\Team::select('id','name')->get(),
            'requests' => \Auth::user()->teamRequests()->select('team_id')->with('team')->get()
        ]);
    }

    public function request(Request $request, Team $team) {
        \Auth::user()->teamRequests()->create([
            'team_id' => $team->id,
        ]);

        TeamMemberRequestReceived::dispatch(\Auth::user(), $team);

        return redirect()->back();
    }

    public function approveRequest(Request $request, Team $team, TeamRequest $teamRequest) {
        $action = new AddTeamMember;
        $action->add(\Auth::user(), $team, $teamRequest->user->email, 'editor');
        $teamRequest->user->switchTeam($team);
        $teamRequest->delete();
        TeamMemberRequestApproved::dispatch(\Auth::user(), $team);

        return redirect()->back();
    }

}
