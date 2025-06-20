<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    public function viewAny(User $user): bool
    {
       return $user->hasRole(['Administrator', 'Staff']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasRole(['Administrator', 'Staff'])) {
            return true;
    }
    return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['Administrator', 'Staff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasRole('Administrator')) {
            return true;

    }
    if ($user->hasRole('Staff')) {
            if ($model->hasRole('Client')) {
                return true;
            }
            return $user->id === $model->id; // Staff can edit their own profile
        }
        // Client can edit their own profile
        if ($user->hasRole('Client')) {
            return $user->id === $model->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }
        if ($user->hasRole('Administrator')) {
            return true;
        }
        if ($user->hasRole('Staff') && $model->hasRole('Client')) {
            return true;
        }
        return false;
    }




    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('Administrator');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
       return $user->hasRole('Administrator');

    }
}
