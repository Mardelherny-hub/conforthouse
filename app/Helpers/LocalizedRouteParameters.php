<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('localized_route_parameters')) {
    function localized_route_parameters($targetLocale)
{
    $parameters = Route::current()->parameters();
    $currentLocale = app()->getLocale();
    $currentRoute = Route::currentRouteName();

    // Si estamos en la ruta de la propiedad (prop.show), cambiamos el slug
    if ($currentRoute === 'prop.show' && isset($parameters['slug'])) {
        $currentSlug = $parameters['slug'];
        $property = null;

        // Buscar primero por slug en la tabla principal
        $property = \App\Models\Property::where('slug', $currentSlug)->first();

        // Si no se encuentra, buscar en las traducciones
        if (!$property) {
            $propertyId = \App\Models\PropertyTranslation::where('slug', $currentSlug)
                ->where('locale', $parameters['locale'])
                ->value('property_id');

            if ($propertyId) {
                $property = \App\Models\Property::find($propertyId);
            }
        }

        // Si encontramos la propiedad, buscar el slug traducido
        if ($property) {
            // Buscar en traducciones
            $translatedSlug = \App\Models\PropertyTranslation::where('property_id', $property->id)
                ->where('locale', $targetLocale)
                ->value('slug');

            // Si encontramos un slug traducido, lo usamos
            if ($translatedSlug) {
                $parameters['slug'] = $translatedSlug;
            } else {
                // Si no hay traducción, usar el slug original de la propiedad
                $parameters['slug'] = $property->slug;
            }
        }
    }

    // Siempre cambiamos el locale
    $parameters['locale'] = $targetLocale;
    return $parameters;
}
}
