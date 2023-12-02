<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\RoutinesWeekly;
use App\Models\User;

class RoutineWeeklyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->rol === "admin";
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RoutinesWeekly $routinesWeekly): bool
    {
        return $user->id == $routinesWeekly->user_id;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RoutinesWeekly $routinesWeekly): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RoutinesWeekly $routinesWeekly): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RoutinesWeekly $routinesWeekly): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RoutinesWeekly $routinesWeekly): bool
    {
        return $user->rol === "admin" ? Response::allow() : Response::deny('You do not have access');
    }
}
