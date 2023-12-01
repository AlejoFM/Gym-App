<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->rol === "admin";
    }

    // TODO: Reorganizar los projectos a rutinas, con sus respectivas entidades, como ejercicios y demas
    // TODO: Agregarle una funcionalidad de membresia a los clientes.
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        //
    }
}