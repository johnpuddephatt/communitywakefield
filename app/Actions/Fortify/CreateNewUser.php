<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Actions\Jetstream\AddTeamMember;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            // return User::create([
            //     'name' => $input['name'],
            //     'email' => $input['email'],
            //     'password' => Hash::make($input['password']),
            // ]);
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $this->autoJoinTeams($user);
            });
        });
    }

    protected function autoJoinTeams($user) {
        $email_domain = explode('@',$user->email)[1];
        $auto_join_teams = Team::where('auto_join', $email_domain)->get();

        foreach($auto_join_teams as $auto_join_team) {
            $action = new AddTeamMember;
            $action->add($user, $auto_join_team, $user->email, 'editor', true);
            $user->switchTeam($auto_join_team);
        }
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    // protected function createTeam(User $user)
    // {
    //     $this->autoJoinTeams($user);
    //
    //     $user->ownedTeams()->save(Team::forceCreate([
    //         'user_id' => $user->id,
    //         'name' => explode(' ', $user->name, 2)[0]."'s Team",
    //         'personal_team' => true,
    //     ]));
    // }
}
