<?php

namespace App\Enums\Helpers\Dates;

enum DaysEnum: int
{
    case SATURDAY = 1;
    case SUNDAY = 2;
    case MONDAY = 3;
    case TUESDAY = 4;
    case WEDNESDAY = 5;
    case THURSDAY = 6;
    case FRIDAY = 7;

    public static function getDaysLabels(): array
    {
        return [
            self::SATURDAY->value => __('helpers.days.saturday'),
            self::SUNDAY->value => __('helpers.days.sunday'),
            self::MONDAY->value => __('helpers.days.monday'),
            self::TUESDAY->value => __('helpers.days.tuesday'),
            self::WEDNESDAY->value => __('helpers.days.wednesday'),
            self::THURSDAY->value => __('helpers.days.thursday'),
            self::FRIDAY->value => __('helpers.days.friday'),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::SATURDAY => __('helpers.days.saturday'),
            self::SUNDAY => __('helpers.days.sunday'),
            self::MONDAY => __('helpers.days.monday'),
            self::TUESDAY => __('helpers.days.tuesday'),
            self::WEDNESDAY => __('helpers.days.wednesday'),
            self::THURSDAY => __('helpers.days.thursday'),
            self::FRIDAY => __('helpers.days.friday'),
        };
    }
}
