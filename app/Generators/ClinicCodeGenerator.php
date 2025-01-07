<?php

namespace App\Generators;

use App\Generators\base\Generator;
use Illuminate\Support\Facades\DB;

class ClinicCodeGenerator extends Generator
{
    /**
     * Generate a unique clinic code.
     *
     * @param int $length      number of digits in the clinic code
     * @param int $batchSize   number of codes to generate in each batch
     * @param int $maxAttempts maximum batch attempts
     *
     * @return int unique clinic code
     *
     * @throws \RuntimeException if unable to generate a unique code
     */
    public static function generate(int $length = 6, int $batchSize = 5, int $maxAttempts = 10, ?string $prefix = '', ?string $suffix = ''): string
    {
        $static = new static();

        return $static->generateUniqueCode($length, $batchSize, $maxAttempts, $prefix, $suffix);
    }

    protected function checkExistingCodes(array $generatedCodes): array
    {
        return DB::table('clinics')
            ->whereIn('code', $generatedCodes)
            ->pluck('code')
            ->toArray();
    }
}
