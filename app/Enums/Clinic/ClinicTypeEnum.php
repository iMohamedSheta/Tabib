<?php

namespace App\Enums\Clinic;

enum ClinicTypeEnum : int
{
    case NORMAL = 1;        // عيادة عادية
    case DENTISTRY = 2;             // عيادات الأسنان
    case INTERNAL_MEDICINE = 3;     // عيادات الأمراض الباطنية
    case DERMATOLOGY = 4;           // عيادة الجلدية
    case OPHTHALMOLOGY = 5;         // عيادة العيون
    case ENT = 6;                   // عيادات الأنف والأذن والحنجرة
    case OBSTETRICS_GYNECOLOGY = 7; // عيادة النساء والولادة
    case CARDIOLOGY = 8;            // عيادة القلب
    case ORTHOPEDICS = 9;           // عيادة العظام
    case UROLOGY = 10;               // عيادة المسالك
    case OTHERS = 11;               // عيادة أخرى

    const DEFAULT = self::NORMAL->value;


    public static function getClinicTypeLabels(): array {
        return [
            self::NORMAL->value => 'عيادة عادية',
            self::DENTISTRY->value => 'عيادات الأسنان',
            self::INTERNAL_MEDICINE->value => 'عيادات الأمراض الباطنية',
            self::DERMATOLOGY->value => 'عيادة الجلدية',
            self::OPHTHALMOLOGY->value => 'عيادة العيون',
            self::ENT->value => 'عيادات الأنف والأذن والحنجرة',
            self::OBSTETRICS_GYNECOLOGY->value => 'عيادة النساء والولادة',
            self::CARDIOLOGY->value => 'عيادة القلب',
            self::ORTHOPEDICS->value => 'عيادة العظام',
            self::UROLOGY->value => 'عيادة المسالك',
            self::OTHERS->value => 'عيادة أخرى',
        ];
    }

    public static function matchClinicTypeLabels($clinicType): string
    {
        return self::getClinicTypeLabels()[$clinicType] ?? 'عيادة اخري';
    }
}
