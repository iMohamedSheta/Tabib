<?php

namespace App\Policies;

use App\Models\ClinicAdmin;
use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $user->role === ClinicAdmin::class;
    }

    public function update(?User $user, Patient $patient): bool
    {
        if (!$user) {
            return false;
        }

        return $user->id === $patient->user->id || $this->isAuthAdminOfPatient($user, $patient);
    }

    public function delete(?User $user, Patient $patient): bool
    {
        if (!$user) {
            return false;
        }

        return $user->id === $patient->user->id || $this->isAuthAdminOfPatient($user, $patient);
    }


    private function isAuthAdminOfPatient(User $user, Patient $patient): bool
    {
        return $user->role === ClinicAdmin::class &&
                $user->clinicAdmin?->clinic_id === $patient->clinic_id;
    }
}
