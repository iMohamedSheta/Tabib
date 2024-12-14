<?php

namespace App\Policies;

use App\Models\ClinicAdmin;
use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patient $patient): bool
    {
        return $user->organization_id == $patient->organization_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isClinicAdmin() || $user->isReceptionist() || $user->isDoctor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Patient $patient): bool
    {
        return $user->organization_id == $patient->organization_id && $user->isClinicAdmin() || $user->isReceptionist() || $user->isDoctor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->organization_id == $patient->organization_id && $user->isClinicAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patient $patient): bool
    {
        return $user->organization_id == $patient->organization_id && $user->isClinicAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patient $patient): bool
    {
        return $user->organization_id == $patient->organization_id && $user->isClinicAdmin();
    }
}
