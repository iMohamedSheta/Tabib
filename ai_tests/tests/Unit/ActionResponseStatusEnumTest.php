<?php

use App\Enums\Actions\ActionResponseStatusEnum;

it('can get the correct integer value for SUCCESS', function () {
    expect(ActionResponseStatusEnum::SUCCESS->value)->toBe(1000);
});

it('can get the correct integer value for ERROR', function () {
    expect(ActionResponseStatusEnum::ERROR->value)->toBe(1001);
});

it('can get the correct integer value for AUTHORIZE_ERROR', function () {
    expect(ActionResponseStatusEnum::AUTHORIZE_ERROR->value)->toBe(1002);
});

it('can be created from an integer value', function () {
    expect(ActionResponseStatusEnum::from(1000))->toBe(ActionResponseStatusEnum::SUCCESS);
    expect(ActionResponseStatusEnum::from(1001))->toBe(ActionResponseStatusEnum::ERROR);
    expect(ActionResponseStatusEnum::from(1002))->toBe(ActionResponseStatusEnum::AUTHORIZE_ERROR);
});

it('throws an exception if an invalid integer value is used', function () {
    expect(fn () => ActionResponseStatusEnum::from(999))->toThrow(ValueError::class);
});
