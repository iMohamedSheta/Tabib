<?php

namespace App\Adapters\Dates;

use Carbon\Carbon;

class CalendarDatepickerAdapter
{
    /**
     * This method expects a datepicker value
     * in format ('Y/m/d h:iK (D)') e.g. [2024/11/05 12:00ص (ثلاثاء)]
     * and converts it to [2024-11-04 00:00:00]
     *
     * @param string $date datepicker value
     * @return string Carbon date format
     */

    public static function handle($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        $dateWithoutDayName = preg_replace('/\s*\(.*?\)\s*/', '', $date);
        $dateFormatted = str_replace(['ص', 'م'], ['AM', 'PM'], $dateWithoutDayName);
        return  Carbon::createFromFormat('Y/m/d g:ia', $dateFormatted)->format('Y-m-d H:i:s');
    }
}
