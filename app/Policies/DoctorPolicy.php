<?php

namespace App\Policies;

use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorPolicy
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

    public function update(?User $user, Doctor $doctor): bool
    {
        if (!$user) {
            return false;
        }

        return $user->id === $doctor->id || $this->isAuthClinicAdminOfDoctorClinic($user, $doctor);
    }

    public function delete(?User $user, Doctor $doctor): bool
    {
        if (!$user) {
            return false;
        }

        return $user->id === $doctor->id || $this->isAuthClinicAdminOfDoctorClinic($user, $doctor);
    }


    private function isAuthClinicAdminOfDoctorClinic(User $user, Doctor $doctor): bool
    {
        return $user->role === ClinicAdmin::class &&
                $user->clinicAdmin?->clinic_id === $doctor->clinic_id;
    }
}
