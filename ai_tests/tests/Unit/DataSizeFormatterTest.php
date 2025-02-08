<?php

use App\Formatters\DataSizeFormatter;

it('can format bytes to bytes', function () {
    expect(DataSizeFormatter::size(100))->toBe('100.00 بايت');
});

it('can format bytes to kilobytes', function () {
    expect(DataSizeFormatter::size(1024))->toBe('1.00 كيلو بايت');
});

it('can format bytes to megabytes', function () {
    expect(DataSizeFormatter::size(1048576))->toBe('1.00 ميجا بايت');
});

it('can format bytes to gigabytes', function () {
    expect(DataSizeFormatter::size(1073741824))->toBe('1.00 جيجا بايت');
});

it('can format bytes to terabytes', function () {
    expect(DataSizeFormatter::size(1099511627776))->toBe('1.00 تيرا بايت');
});

it('can format with different decimals', function () {
    expect(DataSizeFormatter::size(1024, 0))->toBe('1 كيلو بايت');
    expect(DataSizeFormatter::size(1024, 3))->toBe('1.000 كيلو بايت');
});

it('handles zero bytes correctly', function () {
    expect(DataSizeFormatter::size(0))->toBe('0.00 بايت');
});
