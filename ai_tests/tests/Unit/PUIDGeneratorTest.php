<?php

use App\Generators\PUIDGenerator;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

uses(Tests\TestCase::class);


beforeEach(function (): void {
    // Truncate the patients table before each test to ensure a clean slate.
    DB::table('patients')->truncate();
});


describe('PUIDGenerator', function () {
    it('can generate a unique PUID', function () {
        $puid = PUIDGenerator::generate();

        expect($puid)->toBeString();
        expect($puid)->toMatch('/^PAT_\d{8}$/');
    });

    it('generates unique PUIDs even with existing records', function () {
        // Create a patient with a specific PUID to simulate an existing record.
        $existingPuid = 'PAT_12345678';
        Patient::factory()->create(['puid' => $existingPuid]);

        // Generate a new PUID.
        $newPuid = PUIDGenerator::generate();

        // Assert that the generated PUID is different from the existing one.
        expect($newPuid)->not->toEqual($existingPuid);
    });

    it('generates a PUID with custom length', function () {\n        $length = 12;
        $puid = PUIDGenerator::generate($length);

        expect($puid)->toBeString();
        expect($puid)->toMatch('/^PAT_\d{'.$length.'}$/');
    });

    it('generates a PUID with custom prefix and suffix', function () {
        $prefix = 'CUSTOM_';
        $suffix = '_SUFFIX';
        $puid = PUIDGenerator::generate(8, 5, 10, $prefix, $suffix);

        expect($puid)->toBeString();
        expect($puid)->toMatch('/^'.$prefix.'\d{8}'.$suffix.'$/');
    });

    it('handles collisions and generates a unique PUID after multiple attempts', function () {
        // Mock the checkExistingCodes method to always return a collision for the first few attempts.
        $generator = Mockery::mock(PUIDGenerator::class)->makePartial();
        $generator->shouldReceive('checkExistingCodes')
            ->times(3)
            ->andReturn(['PAT_12345678']); // Simulate a collision.
        $generator->shouldReceive('checkExistingCodes')
            ->andReturn([]); // No collision on the 4th attempt.

        $generator->shouldReceive('generateUniqueCode')->passthru();

        $puid = $generator->generate(8, 5, 10);

        expect($puid)->toBeString();
        // Additional assertions can be added to check the format and uniqueness.
    });
});
