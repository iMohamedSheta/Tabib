<?php

namespace App\Generators;

use Illuminate\Support\Facades\DB;

class ClinicCodeGenerator
{
    /**
     * Generate a unique billing code.
     *
     * @param int $length Number of digits in the billing code.
     * @param int $batchSize Number of codes to generate in each batch.
     * @param int $maxAttempts Maximum batch attempts.
     * @return int Unique billing code.
     * @throws \RuntimeException If unable to generate a unique code.
     */
    public static function generate(int $length = 8, int $batchSize = 5, int $maxAttempts = 10): int
    {
        if ($length < 1 || $batchSize < 1) {
            throw new \InvalidArgumentException("Code length and batch size must be at least 1.");
        }

        $min = 10 ** ($length - 1); // 10**5  = 100,000
        $max = (10 ** $length) - 1; // (10**6)-1 = 1,000,000 - 1 = 999,999

        $attempts = 0;

        while ($attempts < $maxAttempts) {
            // Generate a batch of unique random codes
            $codes = [];
            while (count($codes) < $batchSize) {
                $codes[] = random_int($min, $max);
            }

            // Check against the database
            $existingCodes = DB::table('clinics')
                ->whereIn('code', $codes)
                ->pluck('code')
                ->toArray();

            // Find a code that doesn't exist
            $uniqueCodes = array_diff($codes, $existingCodes);

            if (!empty($uniqueCodes)) {
                return reset($uniqueCodes); // Return the first unique code
            }

            $attempts++;
        }

        throw new \RuntimeException("Failed to generate a unique billing code after $maxAttempts attempts.");
    }
}
