<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    public function index(Request $request) {

        $locale = app()->getLocale();
        $properties = Property::with(['images', 'propertyType', 'operation', 'status'])->latest()->take(4)->get();

        //obtengo la primera propiedad destacada
        $featuredProperty = Property::with(['images', 'propertyType', 'operation', 'status'])->where('is_featured', true)->first();
        //dd($featuredProperty);

        // Aplicar traducciones a cada propiedad
        foreach ($properties as $property) {
            $this->applyTranslations($property, $locale);
            $this->translateRelations($property, $locale);
        }

        // Aplicar traducciones a la propiedad destacada solo si existe
        if ($featuredProperty) {
            $this->applyTranslations($featuredProperty, $locale);
        }
        // Si no hay propiedad destacada, tomamos la última propiedad creada
        if (!$featuredProperty) {
            $featuredProperty = Property::with(['images', 'address'])->latest()->first();
        }

        //dd($properties);


        return view('home', compact('properties', 'featuredProperty'));
    }

    private function applyTranslations($property, $locale)
    {
        // Buscar traducción en el idioma solicitado
        $translation = $property->translations()->where('locale', $locale)->first();

        if ($translation) {
            // Aplicar traducción si existe
            $property->title = $translation->title ?? $property->title;
            $property->slug = $translation->slug ?? $property->slug;
            $property->description = $translation->description ?? $property->description;
            $property->meta_description = $translation->meta_description ?? $property->meta_description;
            $property->condition = $translation->condition ?? $property->condition;
            $property->orientation = $translation->orientation ?? $property->orientation;
            $property->exterior_type = $translation->exterior_type ?? $property->exterior_type;
            $property->kitchen_type = $translation->kitchen_type ?? $property->kitchen_type;
            $property->heating_type = $translation->heating_type ?? $property->heating_type;
            $property->interior_carpentry = $translation->interior_carpentry ?? $property->interior_carpentry;
            $property->exterior_carpentry = $translation->exterior_carpentry ?? $property->exterior_carpentry;
            $property->flooring_type = $translation->flooring_type ?? $property->flooring_type;
            $property->views = $translation->views ?? $property->views;
            $property->regime = $translation->regime ?? $property->regime;
        }
    }

    /**
     * Traduce las relaciones de una propiedad (tipo, estado, operación)
     *
     * @param Property $property Propiedad cuyas relaciones se traducirán
     * @param string $locale Idioma
     */
    private function translateRelations($property, $locale)
    {
        // Traducir tipo de propiedad
        if ($property->propertyType) {
            $this->translateRelation($property->propertyType, 'name', $locale);
        }

        // Traducir estado
        if ($property->status) {
            $this->translateRelation($property->status, 'name', $locale);
        }

        // Traducir operación
        if ($property->operation) {
            $this->translateRelation($property->operation, 'name', $locale);
        }
    }

    private function translateRelation($model, $attribute, $locale)
    {
        if ($locale == 'es') {
            return; // Si es español, no necesita traducción
        }

        $originalText = $model->$attribute;

        if (empty($originalText)) {
            return;
        }

        try {
            // Usar el helper para traducir
            $translatedText = LibreTranslateHelper::translate($originalText, 'es', $locale);

            // Aplicar traducción
            $model->$attribute = $translatedText;
        } catch (\Exception $e) {
            // Si falla la traducción, mantener el texto original
            Log::error('Error al traducir relación', [
                'model' => get_class($model),
                'id' => $model->id,
                'attribute' => $attribute,
                'error' => $e->getMessage()
            ]);
        }
    }

}
