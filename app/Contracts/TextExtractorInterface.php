<?php

namespace App\Contracts;

interface TextExtractorInterface
{
    public static function extract(string $filePath): string;

    public static function extractChunks(string $filePath, ?int $chunkSize): \Generator;
}
