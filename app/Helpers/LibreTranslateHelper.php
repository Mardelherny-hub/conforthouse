<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class LibreTranslateHelper
{
    public static function translate($text, $sourceLang = 'es', $targetLang = 'en')
    {
        if (empty($text)) {
            return $text;
        }

        try {
            $response = Http::timeout(10)->post('http://localhost:5000/translate', [
                'q' => $text,
                'source' => $sourceLang,
                'target' => $targetLang,
                'format' => 'text',
            ]);

            if ($response->successful()) {
                $translatedText = $response->json()['translatedText'];
                return $translatedText;
            } else {
                Log::warning('Error en respuesta de LibreTranslate', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return $text;
            }
        } catch (\Exception $e) {
            Log::error('Excepción al conectar con LibreTranslate', [
                'error' => $e->getMessage()
            ]);
            return $text;
        }
    }
}
