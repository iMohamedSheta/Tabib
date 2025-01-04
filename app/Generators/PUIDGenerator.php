<?php

namespace App\Generators;

use App\Generators\base\Generator;
use Illuminate\Support\Facades\DB;

class PUIDGenerator extends Generator
{
    /**
     * Generate a unique Patient User ID.
     *
     * @param int $length Number of digits in the PUID.
     * @param int $batchSize Number of codes to generate in each batch.
     * @param int $maxAttempts Maximum batch attempts.
     * @return int Unique PUID.
     * @throws \RuntimeException If unable to generate a unique code.
     */
    public static function generate(int $length = 8, int $batchSize = 5, int $maxAttempts = 10, ?string $prefix = 'p', ?string $suffix = ''): string
    {
        $self = new static();
        return $self->generateUniqueCode($length, $batchSize, $maxAttempts, $prefix, $suffix);
    }

    protected function checkExistingCodes(array $generatedCodes): array
    {
        return DB::table('patients')
            ->whereIn('puid', $generatedCodes)
            ->pluck('puid')
            ->toArray();
    }
}
