<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;

class DiscussionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Discussion $discussion): bool
    {
        return $discussion->club->isMember($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Discussion $discussion): bool
    {
        return $user->id === $discussion->created_by && $discussion->isOpen();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Discussion $discussion): bool
    {
        return $user->id === $discussion->created_by || $user->is_admin;
    }

    public function close(User $user, Discussion $discussion): bool
    {
        return $user->id === $discussion->created_by || $user->is_admin;
    }

    public function reopen(User $user, Discussion $discussion): bool
    {
        return $user->id === $discussion->created_by || $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Discussion $discussion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Discussion $discussion): bool
    {
        return false;
    }
}
