<?php

use App\Contracts\UserRoleModelInterface;
use PHPUnit\Framework\TestCase;

/*
 * This is just a basic example of how you might test an interface.
 * In reality, you'd want to test the specific implementations of this interface
 * to ensure they behave as expected.
 */

uses(TestCase::class);

describe('UserRoleModelInterface', function () {
    it('exists as an interface', function () {
        expect(interface_exists(UserRoleModelInterface::class))->toBeTrue();
    });

    it('defines a user method', function () {
        $reflection = new ReflectionClass(UserRoleModelInterface::class);
        expect($reflection->hasMethod('user'))->toBeTrue();

        $method = $reflection->getMethod('user');
        expect($method->isPublic())->toBeTrue();
    });
});
