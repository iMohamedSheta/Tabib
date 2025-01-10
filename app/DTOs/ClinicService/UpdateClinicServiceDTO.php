<?php

namespace App\DTOs\ClinicService;

class UpdateClinicServiceDTO
{
    public function __construct(
        protected string $name,
        protected float $price,
        protected ?int $clinic_id = null,
        protected ?string $description = null,
        protected ?string $color = null,
    ) {
    }

    public function clinicServiceData(): array
    {
        return [
            'clinic_id' => $this->clinic_id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'color' => $this->color,
        ];
    }
}
