<?php

namespace App\Extractors\FileTextExtractors;

use App\Contracts\TextExtractorInterface;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PdfTextExtractor implements TextExtractorInterface
{
    /**
     * Extract text from a PDF file.
     */
    public static function extract(string $filePath): string
    {
        $process = new Process(['pdftotext', '-q', $filePath, '-']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    /**
     * Extract text from a PDF file in chunks.
     *
     * @param $filePath  the file path
     * @param $chunkSize the number of yield letters
     */
    public static function extractChunks(string $filePath, ?int $chunkSize = null): \Generator
    {
        $chunkSize ??= config('embedding.chunk_size');

        // Create a temporary file in Laravel's storage path
        $tempFileName = 'temp_' . uniqid('pdf_text_') . '.txt';

        $tempFile = Storage::disk('tmp')->path($tempFileName);

        // Run pdftotext to extract the text from the PDF file and store it in the temporary file
        $process = Process::fromShellCommandline('pdftotext -q ' . escapeshellarg($filePath) . ' ' . escapeshellarg($tempFile));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Failed to run pdftotext: ' . $process->getErrorOutput());
        }

        // Read the text from the temporary file in chunks
        yield from TxtTextExtractor::extractChunks($tempFile, $chunkSize);

        // Clean up by removing the temporary file after processing
        Storage::disk('tmp')->delete($tempFileName);
    }
}
