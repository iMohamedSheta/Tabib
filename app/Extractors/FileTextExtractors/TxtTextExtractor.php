<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;

class TxtTextExtractor implements TextExtractorInterface
{
    /**
     * Extract text from a TXT file.
     */
    public static function extract(string $filePath): string
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return 'Text not found';
        }

        return trim(file_get_contents($filePath));
    }
}
