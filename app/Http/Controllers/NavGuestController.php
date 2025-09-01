<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Operation;

class NavGuestController extends Controller
{
    public function compose(View $view)
    {
        // Obtener la propiedad destacada o la última propiedad publicada si no hay destacada
        $property = Property::where('is_featured', true)->first() ?? Property::latest()->first();

        // Obtener los tipos de propiedades
        $types = PropertyType::all();

        // Obtener las operaciones
        $operations = Operation::all();

        // Obtener el idioma actual
        $locale = app()->getLocale();

        // Aplicar traducciones si hay una propiedad destacada
        if ($property) {
            $this->applyPropertyTranslation($property, $locale);
        }

        // Aplicar traducciones a los tipos de propiedades
        $this->applyCollectionTranslations($types, $locale, 'type');

        // Aplicar traducciones a las operaciones
        $this->applyCollectionTranslations($operations, $locale, 'operation');

        $view->with([
            'property' => $property,
            'types' => $types,
            'operations' => $operations,
        ]);
    }

    /**
     * Aplica traducciones a una propiedad individual
     */
    private function applyPropertyTranslation($property, $locale)
    {
        // Buscar traducción en el idioma solicitado
        $translation = $property->translations()->where('locale', $locale)->first();
        if ($translation) {
            // Aplicar traducción si existe
            $property->title = $translation->title ?? $property->title;
            $property->description = $translation->description ?? $property->description;
            $property->meta_description = $translation->meta_description ?? $property->meta_description;
        }

        return $property;
    }

    /**
     * Aplica traducciones a una colección de modelos
     */
    private function applyCollectionTranslations($collection, $locale, $type)
    {
        foreach ($collection as $item) {
            // Buscar traducción en el idioma solicitado
            $translation = $item->translations()->where('locale', $locale)->first();
            if ($translation) {
                // Aplicar traducción si existe
                if ($type == 'type' || $type == 'operation') {
                    $item->name = $translation->name ?? $item->name;
                }
            }
        }

        return $collection;
    }
}
