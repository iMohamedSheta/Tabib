<?php

use App\Macros\ResponseMacro;

uses(Tests\TestCase::class);

describe('ResponseMacro', function () {
    it('should have a boot method', function () {
        expect(method_exists(ResponseMacro::class, 'boot'))->toBeTrue();
    });

    it('should have a register method', function () {
        expect(method_exists(ResponseMacro::class, 'register'))->toBeTrue();
    });
});
