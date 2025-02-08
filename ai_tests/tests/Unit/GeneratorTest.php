<?php

use App\Generators\Base\Generator;

uses(Tests\TestCase::class);

describe('Generator', function () {
    it('should exist', function () {
        expect(class_exists(Generator::class))->toBeTrue();
    });
});
