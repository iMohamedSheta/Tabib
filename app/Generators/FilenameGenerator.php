<?php

namespace App\Generators;

use App\Generators\Base\Generator;
use Illuminate\Support\Str;

class FilenameGenerator extends Generator
{
    /**
     * Generate a unique file name.
     *
     * @param string      $originalExtension The file's extension (e.g., jpg, png).
     * @param string      $filename          the base file name (optional)
     * @param string|null $prefix            a prefix to prepend to the file name (optional)
     * @param string|null $suffix            a suffix to append to the file name (optional)
     *
     * @return string the generated unique file name
     */
    public static function generate(
        string $originalExtension,
        ?string $filename = null,
        ?string $prefix = null,
        ?string $suffix = null,
    ): string {
        if (empty($originalExtension)) {
            throw new \InvalidArgumentException('File extension cannot be empty.');
        }

        $checkNullablePartValue = fn (?string $part, string $separator = ''): string => !empty($part) && '0' !== $part ? Str::slug($part) . $separator : '';

        // Build components
        $prefixPart = $checkNullablePartValue($prefix, '_');
        $filenamePart = $checkNullablePartValue($filename, '_');
        $timestampPart = now()->format('Y_m_d_H_i_s');
        $uuidPart = Str::uuid();
        $suffixPart = $checkNullablePartValue($suffix);

        // Construct the base name
        $baseName = "{$prefixPart}{$filenamePart}{$timestampPart}_{$uuidPart}{$suffixPart}";

        return urlencode("{$baseName}.{$originalExtension}");
    }
}
