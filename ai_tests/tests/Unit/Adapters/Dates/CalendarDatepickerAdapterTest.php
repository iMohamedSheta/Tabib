<?php

use App\Adapters\Dates\CalendarDatepickerAdapter;

use Carbon\Carbon;


describe('CalendarDatepickerAdapter', function () {
    it('should return null when the input date is empty', function () {
        expect(CalendarDatepickerAdapter::handle(''))
            ->toBeNull();
    });

    it('should convert a datepicker value to Carbon date format', function () {
        $datepickerValue = '2024/11/05 12:00ص (ثلاثاء)';
        $expectedCarbonFormat = '2024-11-05 00:00:00';

        $result = CalendarDatepickerAdapter::handle($datepickerValue);

        expect($result)->toEqual($expectedCarbonFormat);
    });

    it('should handle PM times correctly', function () {
        $datepickerValue = '2024/11/05 06:00م (اربعاء)';
        $expectedCarbonFormat = '2024-11-05 18:00:00';

        $result = CalendarDatepickerAdapter::handle($datepickerValue);

        expect($result)->toEqual($expectedCarbonFormat);
    });

    it('should handle different day names', function () {
        $datepickerValue = '2024/11/05 12:00ص (الجمعة)';
        $expectedCarbonFormat = '2024-11-05 00:00:00';

        $result = CalendarDatepickerAdapter::handle($datepickerValue);

        expect($result)->toEqual($expectedCarbonFormat);
    });
});
