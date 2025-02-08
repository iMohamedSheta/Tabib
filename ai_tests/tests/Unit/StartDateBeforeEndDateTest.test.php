<?php

use App\Rules\StartDateBeforeEndDate;

use function Pest\Faker\faker;


describe('StartDateBeforeEndDate Rule', function () {
    it('passes when start date is before end date', function () {
        $endDate = faker()->dateTimeBetween('now', '+1 week');
        $rule = new StartDateBeforeEndDate($endDate);
        $attribute = 'start_date';
        $value = faker()->dateTimeBetween('-1 week', 'now');
        $fail = function ($message) {
            test()->fail('Validation should not fail.');
        };

        $rule->validate($attribute, $value, $fail);

        expect(true)->toBeTrue(); // Assertion to ensure the test doesn't become risky
    });

    it('fails when start date is after end date', function () {
        $endDate = faker()->dateTimeBetween('now', '+1 week');
        $rule = new StartDateBeforeEndDate($endDate);
        $attribute = 'start_date';
        $value = faker()->dateTimeBetween('+2 week', '+3 week');
        $fail = function ($message) {
            expect($message)->toBe('تاريخ البداية يجب ان يكون قبل تاريخ النهاية');
        };

        $rule->validate($attribute, $value, $fail);
    });

    it('passes when end date attribute is null', function () {
        $rule = new StartDateBeforeEndDate(null);
        $attribute = 'start_date';
        $value = faker()->dateTimeBetween('-1 week', 'now');
        $fail = function ($message) {
            test()->fail('Validation should not fail.');
        };

        $rule->validate($attribute, $value, $fail);

        expect(true)->toBeTrue(); // Assertion to ensure the test doesn't become risky
    });
});
