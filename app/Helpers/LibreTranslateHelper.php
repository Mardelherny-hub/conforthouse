<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class LibreTranslateHelper
{
    public static function translate($text, $sourceLang = 'es', $targetLang = 'en')
    {
        $response = Http::post('https://libretranslate.com/translate', [
            'q' => $text,
            'source' => $sourceLang,
            'target' => $targetLang,
            'format' => 'text',
            //'api_key' => env('LIBRETRANSLATE_API_KEY') // Opcional si se usa una API gratuita
        ]);

        if ($response->successful()) {
            return $response->json()['translatedText'];
        }

        return $text; // Retornar el texto original si falla la traducción
    }
}
