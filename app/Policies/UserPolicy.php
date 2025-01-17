<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $actorUser): bool
    {
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $actorUser, User $targetUser): bool
    {
        return $actorUser->organization_id == $targetUser->organization_id && $actorUser->isClinicAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $actorUser): bool
    {
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $actorUser, User $targetUser): bool
    {
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $actorUser, User $targetUser): bool
    {
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $actorUser, User $targetUser): bool
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $actorUser, User $targetUser): bool
    {
    }

    /**
     * Determine whether the user can permanently delete attached file to the model.
     */
    public function deleteAttachedFile(User $actorUser, User $targetUser): bool
    {
        return $actorUser->organization_id == $targetUser->organization_id && $actorUser->isClinicAdmin();
    }
}
