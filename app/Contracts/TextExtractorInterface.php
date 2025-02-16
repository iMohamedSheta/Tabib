<?php

namespace App\Contracts;

interface TextExtractorInterface
{
    public static function extract(string $file): string;
}
