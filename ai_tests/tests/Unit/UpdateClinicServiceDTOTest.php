<?php

use App\DTOs\ClinicService\UpdateClinicServiceDTO;

use function Pest\Faker\faker;

describe('UpdateClinicServiceDTO', function () {
    it('should return an array of clinic service data', function () {
        $name = faker()->name();
        $price = faker()->randomFloat(2, 10, 100);
        $clinic_id = faker()->numberBetween(1, 10);
        $description = faker()->text();
        $color = faker()->hexColor();

        $dto = new UpdateClinicServiceDTO($name, $price, $clinic_id, $description, $color);

        $expectedData = [
            'clinic_id' => $clinic_id,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'color' => $color,
        ];

        expect($dto->clinicServiceData())->toBe($expectedData);
    });

    it('should return an array of clinic service data with null values', function () {
        $name = faker()->name();
        $price = faker()->randomFloat(2, 10, 100);

        $dto = new UpdateClinicServiceDTO($name, $price);

        $expectedData = [
            'clinic_id' => null,
            'name' => $name,
            'price' => $price,
            'description' => null,
            'color' => null,
        ];

        expect($dto->clinicServiceData())->toBe($expectedData);
    });
});
