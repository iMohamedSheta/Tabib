<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

uses(Tests\TestCase::class)->in('Feature');

it('can create a new action class', function () {
    // Set up
    $actionName = 'TestActionBar';
    $expectedPath = app_path("Actions/{$actionName}.php");

    // Clean up in case the file already exists
    if (File::exists($expectedPath)) {
        unlink($expectedPath);
    }

    // Act
    Artisan::call('make:action', ['name' => $actionName]);

    // Assert
    expect(File::exists($expectedPath))->toBeTrue();

    // Clean up
    unlink($expectedPath);
});

it('should place the action in the correct namespace', function () {
    // Set up
    $actionName = 'AnotherTestActionBar';
    $expectedPath = app_path("Actions/{$actionName}.php");

    // Clean up in case the file already exists
    if (File::exists($expectedPath)) {
        unlink($expectedPath);
    }

    // Act
    Artisan::call('make:action', ['name' => $actionName]);

    // Assert
    $content = File::get($expectedPath);
    expect($content)->toContain('namespace App\\Actions;');

    // Clean up
    unlink($expectedPath);
});

it('should use the action.stub file', function () {
    // Set up
    $actionName = 'YetAnotherTestActionBar';
    $expectedPath = app_path("Actions/{$actionName}.php");

    // Clean up in case the file already exists
    if (File::exists($expectedPath)) {
        unlink($expectedPath);
    }

    // Act
    Artisan::call('make:action', ['name' => $actionName]);

    // Assert
    $content = File::get($expectedPath);
    expect($content)->toContain('// TODO: Implement __invoke() method.');

    // Clean up
    unlink($expectedPath);
});
