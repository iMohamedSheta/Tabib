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

    public static function extractChunks(string $filePath, ?int $chunkSize = null): \Generator
    {
        $chunkSize ??= config('embedding.chunk_size');

        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception('Text not found');
        }

        // Read the text from the temporary file in chunks
        $handle = fopen($filePath, 'r');

        if ($handle) {
            while (!feof($handle)) {
                // Read a chunk of text from the file
                $chunk = fread($handle, $chunkSize);

                if ($chunk !== false) {
                    yield trim($chunk);
                }
            }
            fclose($handle);
        }
    }
}
