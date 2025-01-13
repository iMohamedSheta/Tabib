<?php

namespace App\Formatters;

use Carbon\Carbon;

class AgeFormatter
{
    public static function date(?int $age): ?string
    {
        if (is_null($age)) {
            return null;
        }

        return Carbon::now()->subYears($age)->toDateString();
    }

    public static function ageView(?int $age): ?string
    {
        if (is_null($age)) {
            return null;
        }

        return match (true) {
            1 === $age => __('helpers.age.year'), // سنة
            2 === $age => __('helpers.age.two_years'), // سنتين
            $age >= 3 && $age <= 10 => $age . ' ' . __('helpers.age.years'), // 10 سنين
            default => $age . ' ' . __('helpers.age.year'), // 11 سنة
        };
    }
}
