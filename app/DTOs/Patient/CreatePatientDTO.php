<?php

namespace App\DTOs\Patient;

use App\Formatters\AgeFormatter;
use App\Generators\PUIDGenerator;
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
        public $family_medical_history = null,
        public $chronic_diseases = null,
        public $photo = null,
        public $blood_type = null,
        public $marital_status = null,
        public $occupation = null,
        public $insurance_number = null,
        public $insurance_provider = null,
    ) {
        $this->organization_id = Auth::user()->organization_id;
    }

    public function patientData(): array
    {
        return [
            'puid' => PUIDGenerator::generate(),
            'clinic_id' => $this->clinic_id,
            'age' => $this->age,
            'birth_date' => AgeFormatter::date($this->age),
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'address' => $this->address,
            'allergies' => $this->allergies,
            'notes' => $this->notes,
            'national_card_id' => $this->national_card_id,
            'height' => $this->height,
            'family_medical_history' => $this->family_medical_history,
            'chronic_diseases' => $this->chronic_diseases,
            'blood_type' => $this->blood_type,
            'marital_status' => $this->marital_status,
            'occupation' => $this->occupation,
            'insurance_number' => $this->insurance_number,
            'insurance_provider' => $this->insurance_provider,
            'organization_id' => $this->organization_id,
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
            'organization_id' => $this->organization_id,
        ];
    }
}
