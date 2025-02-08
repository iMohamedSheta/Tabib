<?php

use App\Formatters\DateFormatter;
use Carbon\Carbon;

it('formats date and time in detailed format', function () {
    $dateAndTime = '2024-01-01 10:30:00';
    $formatted = DateFormatter::detailed($dateAndTime);
    $expected = Carbon::parse($dateAndTime)->translatedFormat('Y/m/d - g:ia');
    expect($formatted)->toBe($expected);
});

it('returns null when detailed date and time is null', function () {
    $formatted = DateFormatter::detailed(null);
    expect($formatted)->toBeNull();
});

it('formats date and time in human readable format', function () {
    $dateAndTime = now()->subDays(2)->toDateTimeString();
    $formatted = DateFormatter::human($dateAndTime);

    expect($formatted)->toBeString();
});

it('returns null when human readable date and time is null', function () {
    $formatted = DateFormatter::human(null);
    expect($formatted)->toBeNull();
});

it('formats time correctly', function () {
    $time = '14:45:00';
    $formatted = DateFormatter::time($time);
    $expected = Carbon::parse($time)->translatedFormat('g:iA');
    expect($formatted)->toBe($expected);
});

it('returns null when time is null', function () {
    $formatted = DateFormatter::time(null);
    expect($formatted)->toBeNull();
});

it('formats event time range correctly with end time', function () {
    $start = '10:00:00';
    $end = '11:00:00';
    $formatted = DateFormatter::eventTimeRange($start, $end);

    $startTime = Carbon::parse($start)->translatedFormat('g:iA');
    $endTime = Carbon::parse($end)->translatedFormat('g:iA');
    $expected = "{$startTime} - {$endTime}";

    expect($formatted)->toBe($expected);
});

it('formats event time range correctly without end time', function () {
    $start = '10:00:00';
    $formatted = DateFormatter::eventTimeRange($start, null);

    $startTime = Carbon::parse($start)->translatedFormat('g:iA');
    $endTime = Carbon::parse($start)->addMinutes(10)->translatedFormat('g:iA');
    $expected = "{$startTime} - {$endTime}";

    expect($formatted)->toBe($expected);
});

it('returns null when event start time is null', function () {
    $formatted = DateFormatter::eventTimeRange(null, '11:00:00');
    expect($formatted)->toBeNull();
});
