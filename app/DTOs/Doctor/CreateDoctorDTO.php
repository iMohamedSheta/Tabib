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
        public ?string $other_phone,
        public  $photo,

    ){
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
            'organization_id' => $this->organization_id
        ];
    }

    public function doctorData(): array
    {
        return [
            'specialization' => $this->specialization,
            'organization_id' => $this->organization_id
        ];
    }
}
