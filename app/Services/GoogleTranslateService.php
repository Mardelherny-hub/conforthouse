<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class GoogleTranslateService
{
    protected string $apiKey;
    protected string $endpoint = 'https://translation.googleapis.com/language/translate/v2';

    public function __construct()
    {
        $this->apiKey = config('services.google_translate.key');
    }

    /**
     * Traduce un texto a uno o varios idiomas
     *
     * @param string $text Texto a traducir
     * @param array|string $targetLangs Idioma(s) destino (ej. 'en' o ['en', 'fr', 'de'])
     * @param string|null $sourceLang Idioma origen (por defecto español)
     * @return array|string Retorna una traducción o un array con traducciones por idioma
     */
    public function translate(string $text, array|string $targetLangs, ?string $sourceLang = 'es'): array|string
    {
        if (is_string($targetLangs)) {
            $targetLangs = [$targetLangs];
        }

        $results = [];
        foreach ($targetLangs as $lang) {
            $response = Http::post($this->endpoint, [
                'q' => $text,
                'target' => $lang,
                'source' => $sourceLang,
                'format' => 'text',
                'key' => $this->apiKey,
            ]);

            if ($response->failed()) {
                logger()->error('Google Translate Error', [
                    'target_lang' => $lang,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $results[$lang] = $text;
                continue;
            }

            $results[$lang] = $response->json('data.translations.0.translatedText') ?? $text;
        }

        return count($results) === 1 ? reset($results) : $results;
    }

    /**
     * Traduce múltiples textos a un idioma en una sola solicitud
     *
     * @param array $texts Array de textos a traducir
     * @param string $targetLang Idioma destino
     * @param string|null $sourceLang Idioma origen (por defecto español)
     * @return array Array con los textos traducidos en el mismo orden
     */
    public function translateBatch(array $texts, string $targetLang, ?string $sourceLang = 'es'): array
    {
        // Filtrar textos vacíos
        $textsToTranslate = array_filter($texts, fn($text) => !empty($text));

        if (empty($textsToTranslate)) {
            return $texts; // Devolver array original si no hay nada que traducir
        }

        $response = Http::post($this->endpoint, [
            'q' => $textsToTranslate, // Google Translate API puede recibir un array de strings
            'target' => $targetLang,
            'source' => $sourceLang,
            'format' => 'text',
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            logger()->error('Google Translate Batch Error', [
                'target_lang' => $targetLang,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return $texts; // Devolver los textos originales en caso de error
        }

        $translations = $response->json('data.translations');
        $translatedTexts = [];

        // Reconstruir el array original, manteniendo los índices y los textos vacíos
        $translationIndex = 0;
        foreach ($texts as $index => $text) {
            if (!empty($text)) {
                $translatedTexts[$index] = $translations[$translationIndex++]['translatedText'] ?? $text;
            } else {
                $translatedTexts[$index] = $text; // Mantener valores vacíos como están
            }
        }

        return $translatedTexts;
    }
}
