<?php

namespace App\Generators;

use App\Generators\Base\Generator;
use App\Traits\Generators\GenerateUniqueCodeTrait;
use Illuminate\Support\Facades\DB;

class PUIDGenerator extends Generator
{
    use GenerateUniqueCodeTrait;

    /**
     * Generate a unique Patient User ID.
     *
     * @param int $length      number of digits in the PUID
     * @param int $batchSize   number of codes to generate in each batch
     * @param int $maxAttempts maximum batch attempts
     *
     * @return string unique PUID
     *
     * @throws \RuntimeException if unable to generate a unique code
     */
    public static function generate(int $length = 8, int $batchSize = 5, int $maxAttempts = 10, ?string $prefix = 'PAT_', ?string $suffix = ''): string
    {
        $static = new static();

        return $static->generateUniqueCode($length, $batchSize, $maxAttempts, $prefix, $suffix);
    }

    protected function checkExistingCodes(array $generatedCodes): array
    {
        return DB::table('patients')
            ->whereIn('puid', $generatedCodes)
            ->pluck('puid')
            ->toArray();
    }
}
