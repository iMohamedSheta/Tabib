<?php

use App\Formatters\MoneyFormatter;

it('formats a float amount correctly', function () {
    expect(MoneyFormatter::format(100.50))->toBe('100.50 جنيه مصري');
    expect(MoneyFormatter::format(1000))->toBe('1,000.00 جنيه مصري');
});

it('formats a null amount as zero', function () {
    expect(MoneyFormatter::format(null))->toBe('0.00 جنيه مصري');
});
