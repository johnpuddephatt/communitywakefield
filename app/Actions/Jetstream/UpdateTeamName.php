<?php

namespace App\Actions\Jetstream;

use Image;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($user, $team, array $input)
    {
        Gate::forUser($user)->authorize("update", $team);

        Validator::make($input, [
            "name" => ["required", "string", "max:255"],
            "logo" => ["nullable"],
            "website" => ["nullable", "string"],
            "phone" => ["nullable", "string"],
            "email" => ["nullable", "string"],
            "auto_join" => ["nullable", "string"],
            "info" => ["nullable", "string:300"],
        ])->validateWithBag("updateTeamName");

        if (isset($input["logo"])) {
            $logo = Image::make($input["logo"])
                ->resize(250, 250)
                ->encode("png", 80);
            $logo_name = Str::random(12) . ".png";
            Storage::disk("public")->put($logo_name, $logo);
            $logo_path = Storage::disk("public")->url($logo_name);
        }

        $team
            ->forceFill([
                "name" => $input["name"],
                "logo" => isset($logo_path) ? $logo_path : null,
                "website" => $input["website"],
                "phone" => $input["phone"],
                "email" => $input["email"],
                "auto_join" => $input["auto_join"],
                "info" => $input["info"],
            ])
            ->save();
    }
}
