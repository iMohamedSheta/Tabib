<?php

use App\Contracts\InternalExceptionInterface;

describe('InternalExceptionInterface', function () {
    it('should exist', function () {
        expect(interface_exists(InternalExceptionInterface::class))->toBeTrue();
    });

    it('should have a static method named exception', function () {
        expect(method_exists(InternalExceptionInterface::class, 'exception'))->toBeTrue();

        $reflectionMethod = new ReflectionMethod(InternalExceptionInterface::class, 'exception');
        expect($reflectionMethod->isStatic())->toBeTrue();
    });
});
