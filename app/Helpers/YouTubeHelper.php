<?php

namespace App\Helpers;

class YoutubeHelper
{
    public static function getVideoId($url)
    {
        if (empty($url)) return null;

        // Patrones de URLs de YouTube comunes
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/', // URL normal: https://youtube.com/watch?v=XXX
            '/youtu\.be\/([^?]+)/',             // URL corta: https://youtu.be/XXX
            '/youtube\.com\/embed\/([^?]+)/',    // URL de embed: https://youtube.com/embed/XXX
            '/youtube\.com\/v\/([^?]+)/',        // URL antigua: https://youtube.com/v/XXX
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        // Si la URL ya es un ID (solo contiene caracteres permitidos en IDs de YouTube)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }
}
