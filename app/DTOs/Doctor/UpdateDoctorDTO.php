<?php

namespace App\DTOs\Doctor;

use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class UpdateDoctorDTO
{
    public function __construct(
        public string $username,
        public string $old_password,
        public string $specialization,
        public string $clinic_id,
        public string $first_name,
        public string $last_name,
        public string $phone,
        public ?string $other_phone,
        public ?string $password,
        public ?string $password_confirmation,
        public $photo
    ){}

    public function userData(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password ? Hash::make($this->password) : $this->old_password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'other_phone' => $this->other_phone,
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
