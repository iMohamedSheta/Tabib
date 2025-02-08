<?php

use App\DTOs\Doctor\UpdateDoctorDTO;
use Illuminate\Support\Facades\Hash;

describe('UpdateDoctorDTO', function () {
    it('constructs the DTO correctly', function () {
        $dto = new UpdateDoctorDTO(
            'testuser',
            'oldpassword',
            'Cardiologist',
            'John',
            'Doe',
            '1234567890',
            '0987654321',
            'newpassword',
            'newpassword',
            null
        );

        expect($dto->username)->toBe('testuser')
            ->and($dto->old_password)->toBe('oldpassword')
            ->and($dto->specialization)->toBe('Cardiologist')
            ->and($dto->first_name)->toBe('John')
            ->and($dto->last_name)->toBe('Doe')
            ->and($dto->phone)->toBe('1234567890')
            ->and($dto->other_phone)->toBe('0987654321')
            ->and($dto->password)->toBe('newpassword')
            ->and($dto->password_confirmation)->toBe('newpassword')
            ->and($dto->photo)->toBeNull();
    });

    describe('userData', function () {
        it('returns user data array with hashed password when new password is provided', function () {
            $dto = new UpdateDoctorDTO(
                'testuser',
                'oldpassword',
                'Cardiologist',
                'John',
                'Doe',
                '1234567890',
                '0987654321',
                'newpassword',
                'newpassword',
                null
            );

            $userData = $dto->userData();

            expect($userData['username'])->toBe('testuser')
                ->and(Hash::check('newpassword', $userData['password']))->toBeTrue()
                ->and($userData['first_name'])->toBe('John')
                ->and($userData['last_name'])->toBe('Doe')
                ->and($userData['phone'])->toBe('1234567890')
                ->and($userData['other_phone'])->toBe('0987654321');
        });

        it('returns user data array with old password when new password is not provided', function () {
            $dto = new UpdateDoctorDTO(
                'testuser',
                'oldpassword',
                'Cardiologist',
                'John',
                'Doe',
                '1234567890',
                '0987654321',
                null,
                null,
                null
            );

            $userData = $dto->userData();

            expect($userData['username'])->toBe('testuser')
                ->and($userData['password'])->toBe('oldpassword')
                ->and($userData['first_name'])->toBe('John')
                ->and($userData['last_name'])->toBe('Doe')
                ->and($userData['phone'])->toBe('1234567890')
                ->and($userData['other_phone'])->toBe('0987654321');
        });
    });

    it('doctorData returns doctor data array', function () {
        $dto = new UpdateDoctorDTO(
            'testuser',
            'oldpassword',
            'Cardiologist',
            'John',
            'Doe',
            '1234567890',
            '0987654321',
            'newpassword',
            'newpassword',
            null
        );

        $doctorData = $dto->doctorData();

        expect($doctorData['specialization'])->toBe('Cardiologist');
    });
});
