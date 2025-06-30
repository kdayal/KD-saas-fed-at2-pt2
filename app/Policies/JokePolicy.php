<?php

namespace App\Policies;

use App\Models\Joke;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JokePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Any authenticated user can view the list of jokes.
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Joke $joke): bool
    {
        // Any authenticated user can view a single joke.
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a joke.
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Joke $joke): bool
    {
        // An admin/staff can update any joke, or a user can update their own joke.
        return $user->hasRole(['Administrator', 'Staff']) || $user->id === $joke->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Joke $joke): bool
    {
        // An admin/staff can delete any joke, or a user can delete their own joke.
        return $user->hasRole(['Administrator', 'Staff']) || $user->id === $joke->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Joke $joke): bool
    {
        // Only Admins or Staff should be able to restore jokes.
        return $user->hasRole(['Administrator', 'Staff']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Joke $joke): bool
    {
        // Only Admins should be able to permanently delete jokes.
        return $user->hasRole('Administrator');
    }
}
