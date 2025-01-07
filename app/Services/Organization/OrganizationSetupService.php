<?php

namespace App\Services\Organization;

use App\Models\Organization;

class OrganizationSetupService
{
    public static function setup(Organization $organization): void
    {
        $organization->clinicServices()->createMany(
            self::starterClinicServices($organization),
        );
    }

    private static function starterClinicServices(Organization $organization): array
    {
        return [
            self::makeClinicService('كشف', 250, '#f56565', $organization),
            self::makeClinicService('اعادة كشف', 250, '#009688', $organization),
            self::makeClinicService('متابعة عملية', 200, '#5A67D8', $organization),
        ];
    }

    private static function makeClinicService(string $name, int $price, string $color, Organization $organization, $description = null, $clinic_id = null): array
    {
        return [
            'name' => $name,
            'price' => $price,
            'color' => $color,
            'organization_id' => $organization->id,
            'description' => $description,
            'clinic_id' => $clinic_id,
        ];
    }
}
