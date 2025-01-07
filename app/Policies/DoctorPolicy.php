<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Doctor $doctor): bool
    {
        return $user->organization_id == $doctor->organization_id;
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
    public function update(User $user, Doctor $doctor): bool
    {
        if ($user->organization_id == $doctor->organization_id && $user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Doctor $doctor): bool
    {
        if ($user->organization_id == $doctor->organization_id && $user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Doctor $doctor): bool
    {
        if ($user->organization_id == $doctor->organization_id && $user->isClinicAdmin()) {
            return true;
        }

        return $user->isReceptionist();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Doctor $doctor): bool
    {
        return $user->organization_id == $doctor->organization_id && $user->isClinicAdmin();
    }
}
