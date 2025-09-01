<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleTranslateHelper
{
    /**
     * Traduce un texto de un idioma a varios idiomas de destino
     *
     * @param string $text Texto a traducir
     * @param string $sourceLang Idioma origen
     * @param string ...$targetLangs Idiomas destino (uno o más)
     * @return string Texto traducido al primer idioma destino
     */
    public static function translate(string $text, string $sourceLang = 'es', string ...$targetLangs): string
    {
        if (empty($text)) {
            return $text;
        }

        // Si no se especifica ningún idioma destino, usar inglés por defecto
        if (empty($targetLangs)) {
            $targetLangs = ['en'];
        }

        // Usamos el primer idioma de destino
        $primaryTargetLang = $targetLangs[0];

        $apiKey = config('services.google_translate.key');
        $endpoint = 'https://translation.googleapis.com/language/translate/v2';

        try {
            $response = Http::post($endpoint, [
                'q' => $text,
                'source' => $sourceLang,
                'target' => $primaryTargetLang,
                'format' => 'text',
                'key' => $apiKey,
            ]);

            if ($response->failed()) {
                Log::error('Google Translate Error', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body()
                ]);
                return $text; // Devolver texto original en caso de error
            }

            $data = $response->json();

            // Verificamos la estructura de la respuesta
            if (isset($data['data']['translations'][0]['translatedText'])) {
                return $data['data']['translations'][0]['translatedText'];
            }

            return $text;
        } catch (\Exception $e) {
            Log::error('Google Translate Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $text;
        }
    }

    /**
     * Traduce múltiples textos en una sola solicitud
     *
     * @param array $texts Array de textos a traducir
     * @param string $sourceLang Idioma origen
     * @param string ...$targetLangs Idiomas destino (uno o más)
     * @return array Array con los textos traducidos al primer idioma destino
     */
    public static function translateBatch(array $texts, string $sourceLang = 'es', string ...$targetLangs): array
    {
        if (empty($texts)) {
            return $texts;
        }

        // Si no se especifica ningún idioma destino, usar inglés por defecto
        if (empty($targetLangs)) {
            $targetLangs = ['en'];
        }

        // Usamos el primer idioma de destino
        $primaryTargetLang = $targetLangs[0];

        $apiKey = config('services.google_translate.key');
        $endpoint = 'https://translation.googleapis.com/language/translate/v2';

        try {
            $response = Http::post($endpoint, [
                'q' => $texts,
                'source' => $sourceLang,
                'target' => $primaryTargetLang,
                'format' => 'text',
                'key' => $apiKey,
            ]);

            if ($response->failed()) {
                Log::error('Google Translate Batch Error', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body()
                ]);
                return $texts;
            }

            $data = $response->json();

            // Verificamos la estructura de la respuesta
            if (!isset($data['data']['translations']) || !is_array($data['data']['translations'])) {
                return $texts;
            }

            $result = [];
            foreach ($data['data']['translations'] as $index => $translation) {
                $result[] = $translation['translatedText'] ?? ($texts[$index] ?? '');
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Google Translate Batch Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $texts;
        }
    }
}
