<?php

use App\Enums\Helpers\Dates\DaysEnum;


describe('DaysEnum', function () {
    it('can get days labels', function () {
        $labels = DaysEnum::getDaysLabels();

        expect($labels)->toBeArray();
        expect($labels)->toHaveCount(7);
        expect($labels[DaysEnum::SATURDAY->value])->toBe(__('helpers.days.saturday'));
        expect($labels[DaysEnum::SUNDAY->value])->toBe(__('helpers.days.sunday'));
        expect($labels[DaysEnum::MONDAY->value])->toBe(__('helpers.days.monday'));
        expect($labels[DaysEnum::TUESDAY->value])->toBe(__('helpers.days.tuesday'));
        expect($labels[DaysEnum::WEDNESDAY->value])->toBe(__('helpers.days.wednesday'));
        expect($labels[DaysEnum::THURSDAY->value])->toBe(__('helpers.days.thursday'));
        expect($labels[DaysEnum::FRIDAY->value])->toBe(__('helpers.days.friday'));
    });

    it('can get label for each day', function () {
        expect(DaysEnum::SATURDAY->label())->toBe(__('helpers.days.saturday'));
        expect(DaysEnum::SUNDAY->label())->toBe(__('helpers.days.sunday'));
        expect(DaysEnum::MONDAY->label())->toBe(__('helpers.days.monday'));
        expect(DaysEnum::TUESDAY->label())->toBe(__('helpers.days.tuesday'));
        expect(DaysEnum::WEDNESDAY->label())->toBe(__('helpers.days.wednesday'));
        expect(DaysEnum::THURSDAY->label())->toBe(__('helpers.days.thursday'));
        expect(DaysEnum::FRIDAY->label())->toBe(__('helpers.days.friday'));
    });
});
