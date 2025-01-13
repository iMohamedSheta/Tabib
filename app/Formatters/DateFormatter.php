<?php

namespace App\Formatters;

use App\Enums\Helpers\HelperEnum;
use Carbon\Carbon;

class DateFormatter
{
    public static function detailed(?string $dateAndTime): ?string
    {
        if (is_null($dateAndTime)) {
            return null;
        }

        return Carbon::parse($dateAndTime)->format('Y-m-d - [h:ia]');
    }

    public static function human(?string $dateAndTime): ?string
    {
        if (is_null($dateAndTime)) {
            return null;
        }

        return Carbon::parse($dateAndTime)->diffForHumans();
    }
}
