<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use \Illuminate\Http\Response;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $user->belongsToTeam($service->team);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        // A user can always delete their own content.
        // To delete others' they need the delete permission.
        return ($service->creator && $service->creator->id == $user->id) || $user->hasTeamPermission($team, 'delete');
    }


    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        //
    }
}
