<?php

use App\DTOs\ClinicService\CreateClinicServiceDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


beforeEach(function (): void {
    $this->user = User::factory()->create();
    Auth::setUser($this->user);
});

describe('CreateClinicServiceDTO', function () {
    it('should return the correct data array', function () {
        $name = 'Consultation';
        $price = 50.00;
        $clinicId = 1;
        $description = 'A standard consultation service.';
        $color = '#FFFFFF';

        $dto = new CreateClinicServiceDTO(
            name: $name,
            price: $price,
            clinic_id: $clinicId,
            description: $description,
            color: $color,
        );

        $expectedData = [
            'organization_id' => $this->user->organization_id,
            'clinic_id' => $clinicId,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'color' => $color,
        ];

        expect($dto->clinicServiceData())->toBe($expectedData);
    });

    it('should return the correct data array with null values', function () {
        $name = 'Consultation';
        $price = 50.00;

        $dto = new CreateClinicServiceDTO(
            name: $name,
            price: $price,
            clinic_id: null,
            description: null,
            color: null,
        );

        $expectedData = [
            'organization_id' => $this->user->organization_id,
            'clinic_id' => null,
            'name' => $name,
            'price' => $price,
            'description' => null,
            'color' => null,
        ];

        expect($dto->clinicServiceData())->toBe($expectedData);
    });
});
