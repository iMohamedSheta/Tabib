<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;
use App\Regex\Regex;

class WordTextExtractor implements TextExtractorInterface
{
    /**
     *  Extract text from a Word document.
     *
     * @return string
     *
     * .docx files are just zipped XML files.
     * so we
     */
    public static function extract(string $filePath): string
    {
        $zip = new \ZipArchive();

        if (true === $zip->open($filePath)) {
            // Extract document.xml content
            $xmlContent = $zip->getFromName('word/document.xml');
            $zip->close();

            // Remove XML tags and extract plain text
            if ($xmlContent) {
                // Replace XML tags with spaces to preserve readability
                $text = Regex::removeXmlTags($xmlContent);

                return trim($text);
            }
        }

        return ''; // Return empty string if no text found
    }
}
