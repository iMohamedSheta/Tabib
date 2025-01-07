<?php

namespace App\DTOs\ClinicService;

use Illuminate\Support\Facades\Auth;

class CreateClinicServiceDTO
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
            'organization_id' => Auth::user()->organization_id,
            'clinic_id' => $this->clinic_id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'color' => $this->color,
        ];
    }
}
