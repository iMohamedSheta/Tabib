<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;
use Smalot\PdfParser\Parser as PdfParser;

class PdfTextExtractor implements TextExtractorInterface
{
    /**
     *  Extract text from a pdf file.
     */
    public static function extract(string $filePath): string
    {
        $parser = new PdfParser();
        $pdf = $parser->parseFile($filePath);

        return $pdf->getText();
    }
}
