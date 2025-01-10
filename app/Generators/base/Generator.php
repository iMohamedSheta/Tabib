<?php

namespace App\Generators\base;

abstract class Generator
{
    protected function generateUniqueCode(int $length = 6, int $batchSize = 5, int $maxAttempts = 10, ?string $prefix = '', ?string $suffix = ''): string
    {
        if ($length < 1 || $batchSize < 1) {
            throw new \InvalidArgumentException('Code length and batch size must be at least 1.');
        }

        $min = 10 ** ($length - 1); // 10**5  = 100,000
        $max = (10 ** $length) - 1; // (10**6)-1 = 1,000,000 - 1 = 999,999

        $attempts = 0;

        while ($attempts < $maxAttempts) {
            // Generate a batch of unique random codes
            $codes = [];
            while (count($codes) < $batchSize) {
                $codes[] = $prefix . random_int($min, $max) . $suffix;
            }

            // Check against the database
            $existingCodes = $this->checkExistingCodes($codes);

            // Find a code that doesn't exist
            $uniqueCodes = array_diff($codes, $existingCodes);

            if ($uniqueCodes !== []) {
                return reset($uniqueCodes); // Return the first unique code
            }

            $attempts++;
        }

        throw new \RuntimeException(sprintf('Failed to generate a unique billing code after %d attempts.', $maxAttempts));
    }

    abstract protected function checkExistingCodes(array $generatedCodes): array;
}
