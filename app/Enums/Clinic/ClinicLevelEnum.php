<?php

namespace App\Enums\Clinic;

enum ClinicLevelEnum : int
{
    case PRIMARY = 1;
    case SECONDARY = 2;

    const DEFAULT = self::PRIMARY->value;


    public static function getClinicLevelLabels(): array {
        return [
            self::PRIMARY->value => 'عيادة الرئيسية',
            self::SECONDARY->value => 'عيادة الفرعية',

        ];
    }

    public static function matchClinicLevelLabel($clinicType): string
    {
        return self::getClinicLevelLabels()[$clinicType] ?? 'عيادة اخري';
    }
}
