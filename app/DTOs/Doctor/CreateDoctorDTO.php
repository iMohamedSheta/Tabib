<?php

namespace App\DTOs\Doctor;

use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class CreateDoctorDTO
{
    public $organization_id;

    public function __construct(
        public string $username,
        public string $password,
        public string $specialization,
        public string $first_name,
        public string $last_name,
        public string $phone,
        public ?string $other_phone = null,
        public $photo = null,
        public $license_number = null,
        public $qualifications = null,
        public $available_days = null,
        public $start_time = null,
        public $end_time = null,
        public $telehealth_phone = null,
        public $notes = null,
    ) {
        $this->organization_id = Auth::user()->organization_id;
    }

    public function userData(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'other_phone' => $this->other_phone,
            'role' => Doctor::class,
            'organization_id' => $this->organization_id,
        ];
    }

    public function doctorData(): array
    {
        return [
            'specialization' => $this->specialization,
            'organization_id' => $this->organization_id,
            'license_number' => $this->license_number,
            'qualifications' => $this->qualifications,
            'available_days' => $this->available_days,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'telehealth_phone' => $this->telehealth_phone,
            'notes' => $this->notes,
        ];
    }
}
