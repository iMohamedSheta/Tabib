<?php

namespace App\Enums\Calendar;

enum CalendarTypeEnum: int
{
    case EVENT = 1;
    case APPOINTMENT = 2;
    case MEETING = 3;

    const DEFAULT = self::EVENT->value;

    public function label(): string
    {
        return match ($this) {
            self::EVENT => 'Event',
            self::APPOINTMENT => 'Appointment',
            self::MEETING => 'Meeting',
        };

    }
}
