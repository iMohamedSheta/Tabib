<?php

declare(strict_types=1);

namespace App\Extractors;

use App\Contracts\TextExtractorInterface;
use App\Extractors\FileTextExtractors\CsvTextExtractor;
use App\Extractors\FileTextExtractors\ExcelTextExtractor;
use App\Extractors\FileTextExtractors\PdfTextExtractor;
use App\Extractors\FileTextExtractors\TxtTextExtractor;
use App\Extractors\FileTextExtractors\WordTextExtractor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileTextExtractor
{
    /**
     * Create a new FileTextExtractor instance based on the given file's MIME type.
     *
     * @throws \Exception
     */
    public static function from(string $filePath): TextExtractorInterface
    {
        $filePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filePath);

        if (Storage::exists($filePath)) {
            $filePath = Storage::path($filePath);
        }

        if (!File::exists($filePath) || !File::isReadable($filePath)) {
            throw new \Exception("File not found or not readable: $filePath");
        }

        $mimeType = File::mimeType($filePath);
        $extension = strtolower(File::extension($filePath));

        return match (true) {
            'pdf' === $extension || 'application/pdf' === $mimeType => new PdfTextExtractor(),
            // 'docx' === $extension || 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' === $mimeType => new WordTextExtractor(),
            // 'xlsx' === $extension || 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' === $mimeType => new ExcelTextExtractor(),
            'csv' === $extension || str_contains($mimeType, 'csv') => new CsvTextExtractor(),
            'txt' === $extension || str_contains($mimeType, 'text') => new TxtTextExtractor(),
            default => throw new \Exception("Unsupported file type: MIME - $mimeType, Extension - $extension"),
        };
    }

    public static function extract(string $filePath): string
    {
        $extractor = self::from($filePath);

        return $extractor->extract($filePath);
    }

    public static function extractChunks(string $filePath, ?int $chunkSize = null): \Generator
    {
        $extractor = self::from($filePath);

        yield from $extractor->extractChunks($filePath, $chunkSize);
    }
}
