<?php

namespace App\Generators;

use App\Generators\base\Generator;
use Illuminate\Support\Facades\DB;

class ClinicCodeGenerator extends Generator
{
    /**
     * Generate a unique clinic code.
     *
     * @param int $length Number of digits in the clinic code.
     * @param int $batchSize Number of codes to generate in each batch.
     * @param int $maxAttempts Maximum batch attempts.
     * @return int Unique clinic code.
     * @throws \RuntimeException If unable to generate a unique code.
     */
    public static function generate(int $length = 6, int $batchSize = 5, int $maxAttempts = 10, ?string $prefix = '', ?string $suffix = ''): string
    {
        $self = new static();

        return $self->generateUniqueCode($length, $batchSize, $maxAttempts, $prefix, $suffix);
    }

    public function checkExistingCodes(array $generatedCodes): array
    {
        return DB::table('clinics')
            ->whereIn('code', $generatedCodes)
            ->pluck('code')
            ->toArray();
    }
}
