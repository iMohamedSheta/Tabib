<?php

use App\DTOs\Patient\CreatePatientDTO;
use App\Formatters\AgeFormatter;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Auth::shouldReceive('user')->andReturn($this->user);
});

describe('CreatePatientDTO', function () {
    it('correctly constructs the DTO', function () {
        $dto = new CreatePatientDTO(
            first_name: 'John',
            last_name: 'Doe',
            age: 30,
            clinic_id: 1,
            phone: '123-456-7890',
            gender: 'male',
            other_phone: '098-765-4321',
            nationality: 'American',
            address: '123 Main St',
            allergies: 'Pollen',
            notes: 'Some notes',
            national_card_id: '1234567890',
            height: 180,
            family_medical_history: 'Diabetes',
            chronic_diseases: 'Hypertension',
            photo: 'path/to/photo',
            blood_type: 'O+',
            marital_status: 'Married',
            occupation: 'Engineer',
            insurance_number: 'INS123',
            insurance_provider: 'ProviderA'
        );

        expect($dto->first_name)->toBe('John')
            ->and($dto->last_name)->toBe('Doe')
            ->and($dto->age)->toBe(30)
            ->and($dto->clinic_id)->toBe(1)
            ->and($dto->phone)->toBe('123-456-7890')
            ->and($dto->gender)->toBe('male')
            ->and($dto->other_phone)->toBe('098-765-4321')
            ->and($dto->nationality)->toBe('American')
            ->and($dto->address)->toBe('123 Main St')
            ->and($dto->allergies)->toBe('Pollen')
            ->and($dto->notes)->toBe('Some notes')
            ->and($dto->national_card_id)->toBe('1234567890')
            ->and($dto->height)->toBe(180)
            ->and($dto->family_medical_history)->toBe('Diabetes')
            ->and($dto->chronic_diseases)->toBe('Hypertension')
            ->and($dto->blood_type)->toBe('O+')
            ->and($dto->marital_status)->toBe('Married')
            ->and($dto->occupation)->toBe('Engineer')
            ->and($dto->insurance_number)->toBe('INS123')
            ->and($dto->insurance_provider)->toBe('ProviderA')
            ->and($dto->organization_id)->toBe($this->user->organization_id);
    });

    it('correctly formats patient data array', function () {
        $dto = new CreatePatientDTO(
            first_name: 'John',
            last_name: 'Doe',
            age: 30,
            clinic_id: 1,
            phone: '123-456-7890',
            gender: 'male',
            other_phone: '098-765-4321',
            nationality: 'American',
            address: '123 Main St',
            allergies: 'Pollen',
            notes: 'Some notes',
            national_card_id: '1234567890',
            height: 180,
            family_medical_history: 'Diabetes',
            chronic_diseases: 'Hypertension',
            photo: 'path/to/photo',
            blood_type: 'O+',
            marital_status: 'Married',
            occupation: 'Engineer',
            insurance_number: 'INS123',
            insurance_provider: 'ProviderA'
        );

        $patientData = $dto->patientData();

        expect($patientData['puid'])->not()->toBeNull()
            ->and($patientData['clinic_id'])->toBe(1)
            ->and($patientData['age'])->toBe(30)
            ->and($patientData['birth_date'])->toBe(AgeFormatter::date(30))
            ->and($patientData['gender'])->toBe('male')
            ->and($patientData['nationality'])->toBe('American')
            ->and($patientData['address'])->toBe('123 Main St')
            ->and($patientData['allergies'])->toBe('Pollen')
            ->and($patientData['notes'])->toBe('Some notes')
            ->and($patientData['national_card_id'])->toBe('1234567890')
            ->and($patientData['height'])->toBe(180)
            ->and($patientData['family_medical_history'])->toBe('Diabetes')
            ->and($patientData['chronic_diseases'])->toBe('Hypertension')
            ->and($patientData['blood_type'])->toBe('O+')
            ->and($patientData['marital_status'])->toBe('Married')
            ->and($patientData['occupation'])->toBe('Engineer')
            ->and($patientData['insurance_number'])->toBe('INS123')
            ->and($patientData['insurance_provider'])->toBe('ProviderA')
            ->and($patientData['organization_id'])->toBe($this->user->organization_id);
    });

    it('correctly formats user data array', function () {
        $dto = new CreatePatientDTO(
            first_name: 'John',
            last_name: 'Doe',
            age: 30,
            clinic_id: 1,
            phone: '123-456-7890',
            gender: 'male'
        );

        $userData = $dto->userData();

        expect($userData['first_name'])->toBe('John')
            ->and($userData['last_name'])->toBe('Doe')
            ->and($userData['phone'])->toBe('123-456-7890')
            ->and($userData['other_phone'])->toBeNull()
            ->and($userData['role'])->toBe(Patient::class)
            ->and($userData['organization_id'])->toBe($this->user->organization_id);
    });
});
