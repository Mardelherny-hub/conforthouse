<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\District;
use App\Models\PropertyTranslation;
use Illuminate\Http\Request;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale(); // Obtener el idioma actual

        // Obtener propiedades con su imagen principal, tipo, operación y estado
        $properties = Property::with(['images', 'propertyType', 'operation', 'status'])
            ->latest()
            ->paginate(9);

        // Aplicar traducciones a cada propiedad
        foreach ($properties as $property) {
            $this->applyTranslations($property, $locale);

            // Traducir tipo, estado y operación
            $this->translateRelations($property, $locale);
        }

        return view('properties.index', compact('properties'));
    }

    public function show($locale, $id)
    {
        // Obtener propiedad con imágenes, tipo, operación y estado
        $property = Property::with(['images', 'propertyType', 'operation', 'status'])
            ->findOrFail($id);

        // Aplicar traducciones a la propiedad
        $this->applyTranslations($property, $locale);

        // Traducir tipo, estado y operación
        $this->translateRelations($property, $locale);

        // Obtener 4 propiedades relacionadas con el mismo tipo
        $rel_properties = Property::with('firstImage')
            ->where('property_type_id', $property->property_type_id)
            ->where('id', '!=', $property->id)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        // Aplicar traducciones a las propiedades relacionadas
        foreach ($rel_properties as $rel_property) {
            $this->applyTranslations($rel_property, $locale);
        }

        return view('properties.show', compact('property', 'rel_properties'));
    }

    /**
     * Aplica traducciones a una propiedad
     *
     * @param Property $property Propiedad a traducir
     * @param string $locale Idioma
     */
    private function applyTranslations($property, $locale)
    {
        // Buscar traducción en el idioma solicitado
        $translation = $property->translations()->where('locale', $locale)->first();

        if ($translation) {
            // Aplicar traducción si existe
            $property->title = $translation->title ?? $property->title;
            $property->description = $translation->description ?? $property->description;
            $property->meta_description = $translation->meta_description ?? $property->meta_description;
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

    /**
     * Traduce un atributo específico de un modelo relacionado
     *
     * @param Model $model Modelo a traducir
     * @param string $attribute Atributo a traducir
     * @param string $locale Idioma destino
     */
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
