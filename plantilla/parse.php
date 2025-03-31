<?php
function parseProperties($html) {
    $properties = [];

    // Usar DOMDocument para parsear el HTML
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Encontrar todos los artículos de propiedades
    $articles = $dom->getElementsByTagName('article');

    foreach ($articles as $article) {
        // Extraer el título
        $title = $article->getElementsByTagName('h1')[0]->nodeValue;

        // Extraer referencia y precio
        $details = $article->getElementsByTagName('span');
        $reference = '';
        $price = '';
        foreach ($details as $detail) {
            if (strpos($detail->nodeValue, 'Referencia') !== false) {
                $reference = trim(explode(':', $detail->nodeValue)[1]);
            }
            if (strpos($detail->nodeValue, '€') !== false) {
                $price = str_replace(['€', '.', ' '], '', $detail->nodeValue);
            }
        }

        // Extraer características
        $features = [];
        $ul = $article->getElementsByTagName('ul')[0];
        $lis = $ul->getElementsByTagName('li');
        foreach ($lis as $li) {
            $text = $li->textContent;
            if (strpos($text, 'Habitaciones') !== false) {
                $features['bedrooms'] = (int)filter_var($text, FILTER_SANITIZE_NUMBER_INT);
            }
            if (strpos($text, 'Banos') !== false) {
                $features['bathrooms'] = (int)filter_var($text, FILTER_SANITIZE_NUMBER_INT);
            }
            if (strpos($text, 'Superficie') !== false) {
                $features['surface'] = (int)filter_var($text, FILTER_SANITIZE_NUMBER_INT);
            }
        }

        // Extraer imagen
        $div = $article->getElementsByTagName('div')[0];
        $image = $div->getAttribute('cargafoto');

        $properties[] = [
            'title' => $title,
            'reference' => $reference,
            'price' => (int)$price,
            'features' => $features,
            'image' => $image
        ];
    }

    return $properties;
}
