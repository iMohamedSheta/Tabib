<?php

use App\Traits\Generators\GenerateUniqueCodeTrait;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

class GenerateUniqueCodeTraitTest extends TestCase
{
    use GenerateUniqueCodeTrait;

    protected function checkExistingCodes(array $generatedCodes): array
    {
        // Mock implementation to simulate existing codes in the database.
        // Customize this to match your specific database interaction.
        $existingCodes = ['prefix123456suffix'];

        return array_intersect($generatedCodes, $existingCodes);
    }

    public function testGenerateUniqueCodeReturnsUniqueCode(): void
    {
        $uniqueCode = $this->generateUniqueCode(6, 5, 10, 'prefix', 'suffix');

        $this->assertIsString($uniqueCode);
        $this->assertStringStartsWith('prefix', $uniqueCode);
        $this->assertStringEndsWith('suffix', $uniqueCode);
        $this->assertEquals(18, strlen($uniqueCode));
    }

    public function testGenerateUniqueCodeThrowsExceptionWhenLengthOrBatchSizeIsLessThanOne(): void
    {
        $this->expectException(
            \InvalidArgumentException::class
        );

        $this->expectExceptionMessage(
            'Code length and batch size must be at least 1.'
        );

        $this->generateUniqueCode(0, 5);
    }

    public function testGenerateUniqueCodeThrowsExceptionAfterMaxAttempts(): void
    {
        $this->expectException(
            RuntimeException::class
        );

        $this->expectExceptionMessage(
            'Failed to generate a unique billing code after 2 attempts.'
        );

        $this->generateUniqueCode(6, 1, 2, 'prefix', 'suffix');
    }
}