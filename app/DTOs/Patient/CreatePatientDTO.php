<?php

namespace App\DTOs\Patient;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreatePatientDTO
{

    public $organization_id;

    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $age,
        public string $clinic_id,
        public string $phone,
        public string $gender,
        public ?string $other_phone,
        public ?string $nationality,
        public ?string $address,
        public ?string $allergies,
        public ?string $notes,
        public ?string $national_card_id,
        public ?string $height,
        public ?string $weight,
        public $photo,
    ){
        $this->organization_id = Auth::user()->organization_id;
    }

    public function patientData(): array
    {
        return [
            'clinic_id' => $this->clinic_id,
            'age' => $this->age,
            'birth_date' => Carbon::now()->subYears($this->age)->toDateString(),
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'address' => $this->address,
            'allergies' => $this->allergies,
            'notes' => $this->notes,
            'national_card_id' => $this->national_card_id,
            'height' => $this->height,
            'weight' => $this->weight,
            'organization_id' => $this->organization_id
        ];
    }

    public function userData(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'other_phone' => $this->other_phone,
            'role' => Patient::class,
            'organization_id' => $this->organization_id
        ];
    }
}


