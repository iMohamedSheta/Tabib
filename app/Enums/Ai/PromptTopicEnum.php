<?php

declare(strict_types=1);

namespace App\Enums\Ai;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

    public function getAppointmentPrompt(): string
    {
        return '';
    }

    private function getPatientPrompt(): string
    {
        if (Auth::check() && Auth::user()->isClinicAdmin()) {
            $rememberMinutes = now()->addMinutes(10);

            $cacheKey = Cache::generateOrgScopedKey('patient_prompt_query', self::class);
            $dbDriver = config('database.default');

            $query = (fn() => DB::table('patients as p')
                ->where('p.organization_id', Auth::user()->organization_id)
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->join('events as e', 'e.patient_id', '=', 'p.id')
                ->join('doctors as d', 'd.id', '=', 'e.doctor_id')
                ->join('users as du', 'du.id', '=', 'd.user_id')
                ->select([
                    'p.id as pid',
                    DB::raw("CONCAT(u.first_name, '. ', u.last_name) as patient"),
                    'u.phone',
                    'p.age',
                    'p.gender',
                    'p.puid',
                    'e.id as eid',
                    DB::raw(($dbDriver === 'pgsql' ? "TO_CHAR(e.start_at, 'YYYY-MM-DD HH24:MI')" : "DATE_FORMAT(e.start_at, '%Y-%m-%d %H:%i')") . " as start"),
                    DB::raw(($dbDriver === 'pgsql' ? "TO_CHAR(e.end_at, 'YYYY-MM-DD HH24:MI')" : "DATE_FORMAT(e.end_at, '%Y-%m-%d %H:%i')") . " as end"),
                    DB::raw("CONCAT(du.first_name, '. ', du.last_name) as doctor"),
                ])
                ->get()
                ->map(fn($p): array => [
                    'id' => $p->pid,
                    'patient' => $p->patient,
                    'phone' => $p->phone,
                    'age' => $p->age,
                    'gender' => $p->gender,
                    'event' => [
                        'id' => $p->eid,
                        'start' => $p->start,
                        'end' => $p->end,
                        'doctor' => $p->doctor,
                    ],
                ])
                ->toJson());


            return Cache::remember(
                key: $cacheKey,
                ttl: $rememberMinutes,
                callback: $query,
            );
        }

        return '';
    }
}
