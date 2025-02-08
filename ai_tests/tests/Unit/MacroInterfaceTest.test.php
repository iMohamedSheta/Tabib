<?php

use App\Contracts\MacroInterface;

// Mock class implementing MacroInterface for testing purposes
class MockMacro implements MacroInterface
{
    public static bool $booted = false;
    public static bool $registered = false;

    public static function boot(): void
    {
        static::$booted = true;
    }

    public static function register(): void
    {
        static::$registered = true;
    }
}

describe('MacroInterface', function () {
    it('should define a boot method', function () {
        expect(method_exists(MacroInterface::class, 'boot'))->toBeTrue();
    });

    it('should define a register method', function () {
        expect(method_exists(MacroInterface::class, 'register'))->toBeTrue();
    });

    it('should execute boot method when called', function () {
        MockMacro::boot();
        expect(MockMacro::$booted)->toBeTrue();
    });

    it('should execute register method when called', function () {
        MockMacro::register();
        expect(MockMacro::$registered)->toBeTrue();
    });
});
