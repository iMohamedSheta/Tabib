<?php

namespace App\Formatters;

use Carbon\Carbon;

class DateFormatter
{
    public static function detailed(?string $dateAndTime): ?string
    {
        if (is_null($dateAndTime)) {
            return null;
        }

        return Carbon::parse($dateAndTime)->translatedFormat('Y/m/d - g:ia');
    }

    public static function human(?string $dateAndTime): ?string
    {
        if (is_null($dateAndTime)) {
            return null;
        }

        return Carbon::parse($dateAndTime)->diffForHumans();
    }

    public static function time(?string $time): ?string
    {
        if (is_null($time)) {
            return null;
        }

        return Carbon::parse($time)->translatedFormat('g:iA');
    }

    public static function eventTimeRange(?string $start, ?string $end): ?string
    {
        if (is_null($start)) {
            return null;
        }
        $start = Carbon::parse($start);

        if (is_null($end)) {
            $end = $start->addMinutes(10);
        } else {
            $end = Carbon::parse($end);
        }

        $startTime = $start->translatedFormat('g:iA');
        $endTime = $end->translatedFormat('g:iA');

        return "{$startTime} - {$endTime}";
    }
}
