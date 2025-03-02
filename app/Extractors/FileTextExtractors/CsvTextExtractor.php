<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;
use Generator;

class CsvTextExtractor implements TextExtractorInterface
{
    /**
     * Extract text from a CSV file.
     */
    public static function extract(string $filePath): string
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return 'Text not found';
        }

        $text = '';
        $handle = fopen($filePath, 'r');

        if (false !== $handle) {
            while (($row = fgetcsv($handle)) !== false) {
                $text .= implode(' ', $row) . "\n";
            }
            fclose($handle);
        }

        return trim($text);
    }

    public static function extractChunks(string $filePath, ?int $chunkSize = null): \Generator
    {
        yield from TxtTextExtractor::extractChunks($filePath, $chunkSize);
    }
}
