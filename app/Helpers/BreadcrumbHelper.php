<?php
// app/Helpers/BreadcrumbHelper.php

namespace App\Helpers;

class BreadcrumbHelper
{
    public static function generate(array $items)
    {
        $breadcrumbs = [];
        // Añadir el resto de items
        foreach ($items as $title => $url) {
            $breadcrumbs[] = [
                'title' => $title,
                'url' => is_null($url) ? '#' : $url
            ];
        }

        return $breadcrumbs;
    }
}
