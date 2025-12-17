<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\User;

class ClubPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Club $club): bool
    {
        if ($club->is_private) {
            return $club->isOwner($user) || $club->isMember($user);
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Club $club): bool
    {
        return $club->isOwner($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Club $club): bool
    {
        return $club->isOwner($user);
    }
}
