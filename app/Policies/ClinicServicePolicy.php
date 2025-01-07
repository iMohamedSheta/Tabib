<?php

namespace App\Policies;

use App\Models\ClinicService;
use App\Models\User;

class ClinicServicePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClinicService $clinicService): bool
    {
        return $clinicService->organization_id == $user->organization_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClinicService $clinicService): bool
    {
        if ($clinicService->organization_id == $user->organization_id && $user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClinicService $clinicService): bool
    {
        if ($clinicService->organization_id == $user->organization_id && $user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClinicService $clinicService): bool
    {
        if ($clinicService->organization_id == $user->organization_id && $user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClinicService $clinicService): bool
    {
        return $clinicService->organization_id == $user->organization_id && $user->isClinicAdmin();
    }
}
