<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;
use App\Regex\Regex;

class ExcelTextExtractor implements TextExtractorInterface
{
    /**
     * Extract text from an Excel file.
     */
    public static function extract(string $filePath): string
    {
        $zip = new \ZipArchive();

        if (true === $zip->open($filePath)) {
            $text = '';

            // Extract shared strings (used for text in Excel)
            if (($xmlContent = $zip->getFromName('xl/sharedStrings.xml')) !== false) {
                $text .= Regex::removeXmlTags($xmlContent) . "\n";
            }

            // Loop through all entries in the ZIP file
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);

                // Check if the file is a worksheet (e.g., xl/worksheets/sheet1.xml)
                if (preg_match('/xl\/worksheets\/sheet\d+\.xml/', $filename)) {
                    if (($xmlContent = $zip->getFromName($filename)) !== false) {
                        $text .= Regex::removeXmlTags($xmlContent) . "\n";
                    }
                }
            }

            $zip->close();

            return trim($text);
        }

        return ''; // Return an empty string if the file is not an Excel file
    }
}
