<?php

use App\Helpers\Helper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

it('can log exceptions with details', function () {
    Log::shouldReceive('error')->once()->with('Exception Occurred: ', Mockery::type('array'));

    $exception = new Exception('Test exception', 500);
    Helper::log($exception);
});

it('generates organization scoped cache key', function () {
    Cache::shouldReceive('generateOrgScopedKey')
        ->once()
        ->with('sasasa', Helper::class)
        ->andReturn('expected_cache_key');

    $result = Helper::test();

    expect($result)->toBe('expected_cache_key');
});
