<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request) 
    {
        $locale = app()->getLocale();
        
        // Cargar propiedades con eager loading optimizado
        $properties = Property::with([
    'images', 
    'propertyType',
    'propertyType.translations' => function($q) use ($locale) {
        $q->where('locale', $locale);
    },
    'operation',
    'operation.translations' => function($q) use ($locale) {
        $q->where('locale', $locale);
    },
    'status',
    'status.translations' => function($q) use ($locale) {
        $q->where('locale', $locale);
    },
    'descriptions' => function($q) use ($locale) {
        // Priorizar idioma solicitado, fallback a español
        $q->where(function($subQ) use ($locale) {
            $subQ->where('locale', $locale)
                 ->orWhere('locale', 'es');
        })->orderByRaw("CASE WHEN locale = ? THEN 1 ELSE 2 END", [$locale]);
    }
])
->where('destacado', false)
->latest()
->take(9)
->get();

        // Cargar propiedad destacada con eager loading
        $featuredProperty = Property::with([
            'images', 
            'address',
            'propertyType',
            'propertyType.translations' => function($q) use ($locale) {
                $q->where('locale', $locale);
            },
            'operation',
            'operation.translations' => function($q) use ($locale) {
                $q->where('locale', $locale);
            },
            'status',
            'status.translations' => function($q) use ($locale) {
                $q->where('locale', $locale);
            },
            'descriptions' => function($q) use ($locale) {
                $q->where('locale', $locale)->limit(1);
            }
        ])
        ->where('destacado', true)
        ->first();

        // Si no hay propiedad destacada, tomar la última
        if (!$featuredProperty) {
            $featuredProperty = Property::with([
                'images', 
                'address',
                'descriptions' => function($q) use ($locale) {
                    $q->where('locale', $locale)->limit(1);
                }
            ])
            ->latest()
            ->first();
        }

        // Aplicar traducciones usando datos ya cargados
        $this->applyTranslationsToCollection($properties, $locale);
        
        if ($featuredProperty) {
            $this->applyTranslationsToSingle($featuredProperty, $locale);
        }

        return view('home', compact('properties', 'featuredProperty'));
    }

    /**
     * Aplica traducciones a una sola entidad usando datos ya cargados
     */
    private function applyTranslationsToSingle($entity, $locale)
    {
        if ($locale === 'es') {
            return; // No necesita traducción
        }

        // Para propiedades
        if ($entity instanceof Property) {
            $translation = $entity->descriptions->first();
            if ($translation) {
                $entity->title = $translation->title ?? $entity->title;
                $entity->description = $translation->description ?? $entity->description;
                //$entity->meta_description = $translation->meta_description ?? $entity->meta_description;
                //$entity->slug = $translation->slug ?? $entity->slug;
            }
        }

        // Para relaciones (tipo, operación, estado)
        if ($entity->relationLoaded('propertyType') && $entity->propertyType) {
            $this->translateRelationFromLoaded($entity->propertyType, $locale, 'name');
        }
        if ($entity->relationLoaded('operation') && $entity->operation) {
            $this->translateRelationFromLoaded($entity->operation, $locale, 'name');
        }
        if ($entity->relationLoaded('status') && $entity->status) {
            $this->translateRelationFromLoaded($entity->status, $locale, 'name');
        }
    }

    /**
     * Aplica traducciones a una colección usando datos ya cargados
     */
    private function applyTranslationsToCollection($collection, $locale)
    {
        if ($locale === 'es') {
            return; // No necesita traducción
        }

        foreach ($collection as $item) {
            $this->applyTranslationsToSingle($item, $locale);
        }
    }

    /**
     * Traduce una relación usando traducciones ya cargadas
     */
    private function translateRelationFromLoaded($model, $locale, $attribute)
    {
        if ($locale === 'es' || !$model->relationLoaded('translations')) {
            return;
        }

        $translation = $model->translations->first();
        if ($translation && isset($translation->$attribute)) {
            $model->$attribute = $translation->$attribute;
        }
    }
}