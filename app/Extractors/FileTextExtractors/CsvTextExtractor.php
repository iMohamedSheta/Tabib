<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;

class CsvTextExtractor implements TextExtractorInterface
{
    /**
     * Extract text from a CSV file.
     *
     * @param string $filePath
     * @return string
     */
    public static function extract(string $filePath): string
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return 'Text not found';
        }

        $text = '';
        $handle = fopen($filePath, 'r');

        if ($handle !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                $text .= implode(' ', $row) . "\n";
            }
            fclose($handle);
        }

        return trim($text);
    }
}
