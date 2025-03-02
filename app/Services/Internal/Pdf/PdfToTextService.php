<?php

namespace App\Services\Internal\Pdf\PdfToTextService;

use App\Exceptions\Spatie\PdfToText\BinaryNotFoundException;
use App\Exceptions\Spatie\PdfToText\CouldNotExtractText;
use App\Exceptions\Spatie\PdfToText\PdfNotFound;
use Symfony\Component\Process\Process;

class PdfToTextService
{
    protected string $pdf;

    protected string $binPath;

    protected array $options = [];

    protected int $timeout = 60;

    protected array $env = [];

    public function __construct(?string $binPath = null)
    {
        $this->binPath = $binPath ?? $this->findPdfToText();
    }

    public static function getText(string $pdf, ?string $binPath = null, array $options = [], $timeout = 60, ?\Closure $callback = null): string
    {
        return (new static($binPath))
            ->setOptions($options)
            ->setTimeout($timeout)
            ->setPdf($pdf)
            ->text($callback)
        ;
    }

    public function setPdf(string $pdf): self
    {
        if (!is_readable($pdf)) {
            throw new PdfNotFound("Could not read `{$pdf}`");
        }

        $this->pdf = $pdf;

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $this->parseOptions($options);

        return $this;
    }

    public function addOptions(array $options): self
    {
        $this->options = array_merge(
            $this->options,
            $this->parseOptions($options)
        );

        return $this;
    }

    public function setTimeout(int $timeout): static
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function text(?\Closure $callback = null): string
    {
        $process = new Process(array_merge([$this->binPath], $this->options, [$this->pdf, '-']));
        $process->setTimeout($this->timeout);
        $process = $callback instanceof \Closure ? $callback($process) : $process;
        $process->run();
        if (!$process->isSuccessful()) {
            throw new CouldNotExtractText($process);
        }

        return trim((string) $process->getOutput(), " \t\n\r\0\x0B\x0C");
    }

    protected function findPdfToText(): string
    {
        $commonPaths = [
            '/usr/bin/pdftotext',          // Common on Linux
            '/usr/local/bin/pdftotext',    // Common on Linux
            '/opt/homebrew/bin/pdftotext', // Homebrew on macOS (Apple Silicon)
            '/opt/local/bin/pdftotext',    // MacPorts on macOS
            '/usr/local/bin/pdftotext',    // Homebrew on macOS (Intel)
            'pdftotext',     // Windows (MinGW)
        ];

        foreach ($commonPaths as $path) {
            if (is_executable($path)) {
                return $path;
            }
        }

        throw new BinaryNotFoundException('The required binary was not found or is not executable.');
    }

    protected function parseOptions(array $options): array
    {
        $mapper = function (string $content): array {
            $content = trim($content);
            if ('-' !== ($content[0] ?? '')) {
                $content = '-' . $content;
            }

            return explode(' ', $content, 2);
        };

        $reducer = fn (array $carry, array $option): array => array_merge($carry, $option);

        return array_reduce(array_map($mapper, $options), $reducer, []);
    }
}
