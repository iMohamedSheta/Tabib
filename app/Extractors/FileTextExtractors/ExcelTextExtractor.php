<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;
use App\Regex\Regex;
use Illuminate\Support\Facades\Storage;
use IMohamedSheta\Todo\Attributes\TODO;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

#[TODO('Need to create extractChunks.')]
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
                if (preg_match('/xl\/worksheets\/sheet\d+\.xml/', $filename) && $xmlContent = false !== $zip->getFromName($filename)) {
                    $text .= Regex::removeXmlTags($xmlContent) . "\n";
                }
            }

            $zip->close();

            return trim($text);
        }

        return ''; // Return an empty string if the file is not an Excel file
    }

    public static function extractSharedStringsInChunks(string $filePath, int $chunkSize): \Generator
    {
        // Create the reader for the Excel file and set it to read-only mode
        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);  // Ensure we're only reading actual data (no formatting)
        $reader->setReadEmptyCells(false); // Skip empty cells

        // Load the spreadsheet
        $spreadsheet = $reader->load($filePath);

        // Access the shared string table directly from the workbook
        $sharedStrings = $spreadsheet->getSharedStrings();

        $currentChunk = '';

        foreach ($sharedStrings as $sharedString) {
            // Extract the text from each shared string entry (cleaned if necessary)
            $text = $sharedString->getText(); // Get the actual text from the shared string
            $text = trim($text); // Clean up leading/trailing spaces

            // Skip empty shared strings
            if (empty($text)) {
                continue;
            }

            // Accumulate the text in the current chunk
            $currentChunk .= $text . "\n"; // Use a newline for separation

            // If the accumulated content exceeds the chunk size in bytes, yield the chunk
            if (strlen($currentChunk) >= $chunkSize) {
                yield substr($currentChunk, 0, $chunkSize);
                $currentChunk = substr($currentChunk, $chunkSize); // Reset the chunk after yielding
            }
        }

        // After finishing all shared strings, yield any remaining content if necessary
        if (strlen($currentChunk) > 0) {
            yield $currentChunk;
        }
    }

    public static function extractChunksf(string $filePath, ?int $chunkSize): \Generator
    {
        // Create a temporary file in Laravel's storage path
        $tempFileName = 'temp_' . uniqid('pdf_text_') . '.txt';

        $tempFile = Storage::disk('tmp')->path($tempFileName);

        self::extractExcelText($filePath, $tempFile);

        yield from TxtTextExtractor::extractChunks($tempFile, $chunkSize);

        // Clean up by removing the temporary file after processing
        Storage::disk('tmp')->delete($tempFileName);
    }

    public static function extractChunksz(string $filePath, ?int $chunkSize): \Generator
    {
        $chunkSize ??= config('embedding.chunk_size');

        $zip = new \ZipArchive();

        if (true === $zip->open($filePath)) {
            // Extract shared strings (used for text in Excel)
            if (($xmlContent = $zip->getFromName('xl/sharedStrings.xml')) !== false) {
                $text = Regex::removeXmlTags($xmlContent) . "\n";
                yield substr($text, 0, $chunkSize);  // Yield the first chunk
                $text = substr($text, $chunkSize); // Remaining text
            }

            // Loop through all entries in the ZIP file
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                // Check if the file is a worksheet (e.g., xl/worksheets/sheet1.xml)
                if (preg_match('/xl\/worksheets\/sheet\d+\.xml/', $filename)) {
                    // Get stream of the XML file
                    $stream = $zip->getStream($filename);
                    if ($stream) {
                        // Read the file in chunks and yield each chunk
                        $buffer = '';
                        while (!feof($stream)) {
                            $buffer .= fread($stream, 8192); // Read in 8KB chunks

                            // Remove XML tags from the current buffer
                            $buffer = Regex::removeXmlTags($buffer);

                            // Yield a chunk if buffer size reaches the specified chunkSize
                            if (strlen($buffer) >= $chunkSize) {
                                yield substr($text, 0, $chunkSize);
                                $buffer = substr($buffer, $chunkSize);  // Keep remaining data
                            }
                        }
                        fclose($stream);
                    }
                }
            }

            $zip->close();
        }

        // Yield any remaining content if necessary
        if (isset($buffer) && strlen($buffer) > 0) {
            yield $buffer;
        }
    }

    public static function extractChunks(string $filePath, ?int $chunkSize): \Generator
    {
        $chunkSize ??= config('embedding.chunk_size');

        // Create the reader for the Excel file and set it to read-only mode
        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);  // Ensure we're only reading actual data
        $reader->setReadEmptyCells(false);

        $spreadsheet = $reader->load($filePath);

        $currentChunk = '';

        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getRowIterator() as $row) {
                $rowText = [];

                foreach ($row->getCellIterator() as $cell) {
                    // Check if the cell value is not a formula and is a string or number
                    if (
                        \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING === $cell->getDataType()
                    ) {
                        $rowText[] = $cell->getValue();
                    }
                }

                $currentChunk .= implode("\t", $rowText) . PHP_EOL;

                // If the accumulated content exceeds the chunk size in bytes, yield the chunk
                if (strlen($currentChunk) >= $chunkSize) {
                    yield substr($currentChunk, 0, $chunkSize);
                    $currentChunk = substr($currentChunk, $chunkSize);
                }
            }
        }

        // After finishing all rows, yield any remaining content if necessary
        if (strlen($currentChunk) > 0) {
            yield $currentChunk;
        }
    }

    public static function extractExcelText(string $excelFilePath, string $outputFilePath, int $writerBatchSize = 500): void
    {
        $reader = IOFactory::createReaderForFile($excelFilePath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excelFilePath);

        $outputFile = fopen($outputFilePath, 'w');

        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            $batch = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowText = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowText[] = $cell->getValue();
                }

                $batch[] = implode("\t", $rowText) . PHP_EOL;

                if (count($batch) >= $writerBatchSize) {
                    fwrite($outputFile, implode('', $batch));
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                fwrite($outputFile, implode('', $batch));
            }
        }

        fclose($outputFile);
    }

    /**
     * Get shared strings from the spreadsheet.
     */
    private static function getSharedStrings(Spreadsheet $spreadsheet): array
    {
        $sharedStrings = [];

        // Get shared strings from the first worksheet (adjust if needed)
        $sheet = $spreadsheet->getSheet(0);

        // Loop through all cells in the sheet and find shared strings
        foreach ($sheet->getCellCollection() as $cell) {
            if (\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING === $cell->getDataType()) {
                $sharedStrings[] = $cell->getValue();
            }
        }

        return $sharedStrings;
    }
}
