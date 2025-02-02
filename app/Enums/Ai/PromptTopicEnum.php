<?php

namespace App\Enums\Ai;

use Illuminate\Support\Facades\DB;

enum PromptTopicEnum: int
{
    case PATIENT = 1;
    case APPOINTMENT = 2;
    case INVOICE = 3;

    public static function getTopicOptions(): array
    {
        return [
            self::PATIENT->value => 'المرضى',
            self::APPOINTMENT->value => 'المواعيد والحجوزات',
            self::INVOICE->value => 'الفواتير',
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::PATIENT => 'المرضى',
            self::APPOINTMENT => 'المواعيد والحجوزات',
            self::INVOICE => 'الفواتير',
        };
    }

    public function prompt(): string
    {
        return match ($this) {
            self::PATIENT => $this->getPatientPrompt(),
            self::APPOINTMENT => 'المواعيد والحجوزات',
            self::INVOICE => 'الفواتير',
        };
    }

    public function getPatientPrompt(): string
    {
        if (auth()->user()->isClinicAdmin()) {
            return DB::table('patients as p')->where('p.organization_id', auth()->user()->organization_id)
                ->select([
                    'p.id as patient_id',
                    'u.first_name',
                    'u.last_name',
                    'u.phone',
                    'u.other_phone',
                    'p.age',
                    'p.gender',
                    'p.address',
                    'p.puid',
                    'e.id as event_id',
                    'e.start_at',
                    'e.end_at',
                    'p.organization_id',
                    'du.first_name as doctor_first_name',
                    'du.last_name as doctor_last_name',
                ])
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->join('events as e', 'e.patient_id', '=', 'p.id')
                ->join('doctors as d', 'd.id', '=', 'e.doctor_id')
                ->join('users as du', 'du.id', '=', 'd.user_id')
                ->get()
                ->toJson();
        }

        return '';
    }
}
