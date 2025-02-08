<?php

use App\DTOs\Doctor\CreateDoctorDTO;
use App\Models\Doctor;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

uses(Tests\TestCase::class)->in('Unit');

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    Auth::setUser($this->user);
});

describe('CreateDoctorDTO', function () {
    it('can create a CreateDoctorDTO instance', function () {
        $dto = new CreateDoctorDTO(
            'testuser',
            'password',
            'Cardiologist',
            'John',
            'Doe',
            '123-456-7890'
        );

        expect($dto)->toBeInstanceOf(CreateDoctorDTO::class);
        expect($dto->username)->toBe('testuser');
        expect($dto->password)->toBe('password');
        expect($dto->specialization)->toBe('Cardiologist');
        expect($dto->first_name)->toBe('John');
        expect($dto->last_name)->toBe('Doe');
        expect($dto->phone)->toBe('123-456-7890');
        expect($dto->organization_id)->toBe($this->user->organization_id);
    });

    it('returns correct user data array', function () {
        $dto = new CreateDoctorDTO(
            'testuser',
            'password',
            'Cardiologist',
            'John',
            'Doe',
            '123-456-7890'
        );

        $userData = $dto->userData();

        expect($userData)->toBeArray();
        expect($userData['username'])->toBe('testuser');
        expect($userData['password'])->toBe('password');
        expect($userData['first_name'])->toBe('John');
        expect($userData['last_name'])->toBe('Doe');
        expect($userData['phone'])->toBe('123-456-7890');
        expect($userData['role'])->toBe(Doctor::class);
        expect($userData['organization_id'])->toBe($this->user->organization_id);
    });

    it('returns correct doctor data array', function () {
        $dto = new CreateDoctorDTO(
            'testuser',
            'password',
            'Cardiologist',
            'John',
            'Doe',
            '123-456-7890',
            '987-654-3210',
            null,
            '12345',
            'MBBS',
            'Monday,Tuesday',
            '09:00',
            '17:00',
            '111-222-3333',
            'Some notes'
        );

        $doctorData = $dto->doctorData();

        expect($doctorData)->toBeArray();
        expect($doctorData['specialization'])->toBe('Cardiologist');
        expect($doctorData['organization_id'])->toBe($this->user->organization_id);
        expect($doctorData['license_number'])->toBe('12345');
        expect($doctorData['qualifications'])->toBe('MBBS');
        expect($doctorData['available_days'])->toBe('Monday,Tuesday');
        expect($doctorData['start_time'])->toBe('09:00');
        expect($doctorData['end_time'])->toBe('17:00');
        expect($doctorData['telehealth_phone'])->toBe('111-222-3333');
        expect($doctorData['notes'])->toBe('Some notes');
    });
});
