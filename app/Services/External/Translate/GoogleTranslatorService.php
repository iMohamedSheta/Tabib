<?php

namespace App\Services\External\Translate;

use Illuminate\Support\Facades\Http;

class GoogleTranslatorService
{
    public static function translate(string $text, string $targetLang = 'en'): string
    {
        $response = Http::get('https://translate.googleapis.com/translate_a/single', [
            'client' => 'gtx',  // Use Google's internal translation API
            'sl' => 'auto',  // Source language (auto-detect)
            'tl' => $targetLang,  // Target language (English)
            'dt' => 't',  // Get only translated text
            'q' => $text,  // The text to translate
        ]);

        return $response->json()[0][0][0] ?? $text;
    }
}
