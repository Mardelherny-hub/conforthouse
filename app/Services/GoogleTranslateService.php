<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    public function translate($text, $locale)
    {
        return $this->translator->setSource('es')->setTarget($locale)->translate($text);
    }
}
