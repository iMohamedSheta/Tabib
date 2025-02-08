<?php

use App\Macros\CacheMacro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Mockery;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    Cache::clearResolvedInstances();
});

it('registers the generateOrgScopedKey macro', function (): void {
    CacheMacro::boot();

    expect(Cache::hasMacro('generateOrgScopedKey'))->toBeTrue();
});

it('generates organization-scoped cache key correctly', function (): void {
    CacheMacro::boot();

    $organizationId = 123;
    $mockUser = Mockery::mock();
    $mockUser->shouldReceive('getAttribute')->with('organization_id')->andReturn($organizationId);
    Auth::shouldReceive('user')->once()->andReturn($mockUser);

    $key = 'test_key';
    $class = 'App\Services\TestService';
    $expectedKey = strtolower(str_replace(['\\', '::'], ':', $class)) . ':' . $key . ':org_' . $organizationId;

    $generatedKey = Cache::generateOrgScopedKey($key, $class);

    expect($generatedKey)->toBe($expectedKey);
});

it('generates organization-scoped cache key correctly with different organization ID', function (): void {
    CacheMacro::boot();

    $organizationId = 456;
    $mockUser = Mockery::mock();
    $mockUser->shouldReceive('getAttribute')->with('organization_id')->andReturn($organizationId);
    Auth::shouldReceive('user')->once()->andReturn($mockUser);

    $key = 'another_key';
    $class = 'App\Models\AnotherModel';
    $expectedKey = strtolower(str_replace(['\\', '::'], ':', $class)) . ':' . $key . ':org_' . $organizationId;

    $generatedKey = Cache::generateOrgScopedKey($key, $class);

    expect($generatedKey)->toBe($expectedKey);
});
