<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to define your test case is being binding to the TestCases class.
| Meaning you can use any of the methods provided in the class.
|
*/

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, it's often helpful to add your own custom
| assertions to Pest. This has been already done for you!
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful, you may need to add some helper functions to ease the burdens of your tests.
| Here you can define functions that would be available in all your tests.
|
*/

