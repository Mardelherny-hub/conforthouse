<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class LibreTranslateHelper
{
    /**
     * Traduce un texto a varios idiomas
     *
     * @param string $text Texto a traducir
     * @param string $sourceLang Idioma origen
     * @param array|string $targetLangs Idioma(s) destino
     * @param int $timeout Tiempo máximo de espera en segundos
     * @param int $retries Número de reintentos
     * @return array|string Texto(s) traducido(s)
     */
    public static function translate($text, $sourceLang = 'es', $targetLangs = 'en', $timeout = 20, $retries = 2)
    {
        if (empty($text)) {
            return $text;
        }

        // Si targetLangs es string, convertirlo a array
        if (!is_array($targetLangs)) {
            $targetLangs = [$targetLangs];
        }

        $results = [];

        foreach ($targetLangs as $targetLang) {
            $attempt = 0;
            $success = false;

            while (!$success && $attempt <= $retries) {
                try {
                    // Añadir pequeño retraso entre reintentos
                    if ($attempt > 0) {
                        sleep(2);
                    }

                    $response = Http::timeout($timeout)->post('http://localhost:5000/translate', [
                        'q' => $text,
                        'source' => $sourceLang,
                        'target' => $targetLang,
                        'format' => 'text',
                    ]);

                    if ($response->successful()) {
                        $results[$targetLang] = $response->json()['translatedText'];
                        $success = true;
                    } else {
                        Log::warning('Error en respuesta de LibreTranslate (intento ' . ($attempt + 1) . '/' . ($retries + 1) . ')', [
                            'status' => $response->status(),
                            'body' => $response->body(),
                            'target' => $targetLang
                        ]);

                        // Si es el último intento, guardar el texto original
                        if ($attempt == $retries) {
                            $results[$targetLang] = $text;
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Excepción al conectar con LibreTranslate (intento ' . ($attempt + 1) . '/' . ($retries + 1) . ')', [
                        'error' => $e->getMessage(),
                        'target' => $targetLang
                    ]);

                    // Si es el último intento, guardar el texto original
                    if ($attempt == $retries) {
                        $results[$targetLang] = $text;
                    }
                }

                $attempt++;
            }
        }

        // Si solo se solicitó un idioma, devolver string
        return count($results) === 1 ? reset($results) : $results;
    }

    /**
     * Traduce un texto a inglés, francés y alemán
     *
     * @param string $text Texto a traducir
     * @param string $sourceLang Idioma origen
     * @param int $timeout Tiempo máximo de espera en segundos
     * @return array Texto traducido a en, fr y de
     */
    public static function translateToMultiple($text, $sourceLang = 'es', $timeout = 20)
    {
        return self::translate($text, $sourceLang, ['en', 'fr', 'de', 'nl'], $timeout);
    }

    /**
     * Traduce solo al neerlandés
     *
     * @param string $text Texto a traducir
     * @param string $sourceLang Idioma origen
     * @param int $timeout Tiempo máximo de espera en segundos
     * @return string Texto traducido a neerlandés
     */
    public static function translateToDutch($text, $sourceLang = 'es', $timeout = 20)
    {
        return self::translate($text, $sourceLang, 'nl', $timeout);
    }

    /**
     * Verifica si el servicio de traducción está disponible
     *
     * @param int $timeout Tiempo máximo de espera en segundos
     * @return bool True si el servicio está disponible
     */
    public static function isServiceAvailable($timeout = 5)
    {
        try {
            $response = Http::timeout($timeout)->get('http://localhost:5000/languages');
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('El servicio LibreTranslate no está disponible', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
