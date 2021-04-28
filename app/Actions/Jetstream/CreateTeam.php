<?php

namespace App\Actions\Jetstream;

use Image;
use Storage;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use App\Events\TeamCreated;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {

        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable'],
            'website' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'auto_join' => ['nullable', 'string'],
            'info' => ['nullable', 'string:500'],

        ])->validateWithBag('createTeam');

        if(isset($input['logo'])) {
            $logo = Image::make($input['logo'])->resize(250, 250)->encode('png', 80);
            $logo_name = Str::random(12) . '.png';
            Storage::disk('public')->put($logo_name, $logo);
            $logo_path = Storage::disk('public')->url($logo_name);
        }

        AddingTeam::dispatch($user);

        $team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'logo' => $logo_path,
            'website' => $input['website'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'auto_join' => $input['auto_join'],
            'info' => $input['info'],
            'personal_team' => false,
        ]);

        \Auth::user()->switchTeam($team);

        TeamCreated::dispatch($team, $user);

        return $team;
    }
}
