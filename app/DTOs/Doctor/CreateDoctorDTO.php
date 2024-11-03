<?php

namespace App\DTOs\Doctor;

use App\Models\Doctor;

class CreateDoctorDTO
{
    public function __construct(
        public string $username,
        public string $password,
        public string $specialization,
        public string $clinic_id,
        public string $first_name,
        public string $last_name,
        public string $phone,
        public ?string $other_phone,
        public  $photo
    ){}

    public function userData(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'other_phone' => $this->other_phone,
            'role' => Doctor::class
        ];
    }

    public function doctorData(): array
    {
        return [
            'specialization' => $this->specialization,
            'clinic_id' => $this->clinic_id
        ];
    }
}
