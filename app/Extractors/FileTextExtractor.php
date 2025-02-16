<?php

declare(strict_types=1);

namespace App\Extractors;

use App\Contracts\TextExtractorInterface;
use App\Enums\Extractor\FileTypeEnum;
use App\Extractors\FileTextExtractors\CsvTextExtractor;
use App\Extractors\FileTextExtractors\ExcelTextExtractor;
use App\Extractors\FileTextExtractors\PdfTextExtractor;
use App\Extractors\FileTextExtractors\TxtTextExtractor;
use App\Extractors\FileTextExtractors\WordTextExtractor;
use Exception;
use Illuminate\Support\Facades\File;

class FileTextExtractor
{
    /**
     * Create a new FileTextExtractor instance based on the given file's MIME type.
     *
     * @param string $filePath
     * @return TextExtractorInterface
     *
     * @throws Exception
     */
    public static function from(string $filePath): TextExtractorInterface
    {
        if (!File::exists($filePath) || !File::isReadable($filePath)) {
            throw new Exception("File not found or not readable: $filePath");
        }

        $mimeType = File::mimeType($filePath);
        $extension = strtolower(File::extension($filePath));

        return match (true) {
            $extension === 'pdf' || $mimeType === 'application/pdf' => new PdfTextExtractor(),
            $extension === 'docx' || $mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => new WordTextExtractor(),
            $extension === 'xlsx' || $mimeType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => new ExcelTextExtractor(),
            $extension === 'csv' || strpos($mimeType, 'csv') !== false => new CsvTextExtractor(),
            $extension === 'txt' || strpos($mimeType, 'text') !== false => new TxtTextExtractor(),
            default => throw new Exception("Unsupported file type: MIME - $mimeType, Extension - $extension"),
        };
    }

    public static function extract(string $filePath): string
    {
        $extractor = self::from($filePath);
        return $extractor->extract($filePath);
    }
}
