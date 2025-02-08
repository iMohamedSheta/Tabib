<?php

use App\Enums\Calendar\CalendarTypeEnum;

it('can get the correct label for each calendar type', function () {
    expect(CalendarTypeEnum::EVENT->label())->toBe('Event');
    expect(CalendarTypeEnum::APPOINTMENT->label())->toBe('Appointment');
    expect(CalendarTypeEnum::MEETING->label())->toBe('Meeting');
    expect(CalendarTypeEnum::PATIENT_APPOINTMENT->label())->toBe('Patient Appointment');
});

it('has a default value of EVENT', function () {
    expect(CalendarTypeEnum::DEFAULT)->toBe(CalendarTypeEnum::EVENT->value);
});
