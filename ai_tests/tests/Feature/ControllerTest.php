<?php

use App\Http\Controllers\Controller;

uses(Tests\TestCase::class)->in('Feature');

describe('Controller', function () {
    it('should exist', function () {
        expect(class_exists(Controller::class))->toBeTrue();
    });
});
