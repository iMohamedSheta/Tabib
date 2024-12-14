<?php

namespace App\DTOs\Patient;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreatePatientDTO
{

    public $organization_id;

    public function __construct(
        public $first_name,
        public $last_name,
        public $age,
        public $clinic_id,
        public $phone,
        public $gender,
        public $other_phone = null,
        public $nationality = null,
        public $address = null,
        public $allergies = null,
        public $notes = null,
        public $national_card_id = null,
        public $height = null,
        public $weight = null,
        public $photo = null,
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


