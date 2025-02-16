<?php

namespace App\Regex;

class Regex
{
    /**
     * Remove XML/HTML tags from a string.
     */
    public static function removeXmlTags(string $input): string
    {
        return preg_replace('/<[^>]+>/', ' ', $input);
    }
}
