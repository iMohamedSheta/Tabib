<?php

use App\Enums\Helpers\HelperEnum;

it('can get the correct label for NOT_AVAILABLE', function () {
    expect(HelperEnum::NOT_AVAILABLE->label())->toBe(__('helpers.helper.not_available'));
});

it('can get the correct label for UNKNOWN', function () {
    expect(HelperEnum::UNKNOWN->label())->toBe(__('helpers.helper.unknown'));
});
