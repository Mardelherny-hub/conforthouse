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
        
        // Propiedades principales del Home (limitadas)
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
                    $q->where(function($subQ) use ($locale) {
                        $subQ->where('locale', $locale)
                            ->orWhere('locale', 'es');
                    })->orderByRaw("CASE WHEN locale = ? THEN 1 ELSE 2 END", [$locale]);
                }
            ])
            ->where('destacado', false)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // Propiedad destacada
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
            ->orderBy('id', 'desc')
            ->first();

        if (!$featuredProperty) {
            $featuredProperty = Property::with(['images','address','descriptions' => function($q) use ($locale) {
                $q->where('locale', $locale)->limit(1);
            }])->orderBy('id', 'desc')->first();
        }

        // 👉 Propiedades para el mapa (mismo conjunto, sin límite)
        $mapProperties = Property::with([
                'images', 
                'address',
                'descriptions' => function($q) use ($locale) {
                    $q->where(function($subQ) use ($locale) {
                        $subQ->where('locale', $locale)
                            ->orWhere('locale', 'es');
                    })->orderByRaw("CASE WHEN locale = ? THEN 1 ELSE 2 END", [$locale]);
                }
            ])
            ->whereHas('address', function($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->orderBy('id', 'desc')
            ->get();

        // Traducciones
        $this->applyTranslationsToCollection($properties, $locale);
        if ($featuredProperty) $this->applyTranslationsToSingle($featuredProperty, $locale);

        return view('home', compact('properties', 'featuredProperty', 'mapProperties'));
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
            }

            // Traducir relaciones si están cargadas
            if ($entity->relationLoaded('propertyType') && $entity->propertyType) {
                $typeTranslation = $entity->propertyType->translations->first();
                if ($typeTranslation) {
                    $entity->propertyType->name = $typeTranslation->name;
                }
            }

            if ($entity->relationLoaded('operation') && $entity->operation) {
                $opTranslation = $entity->operation->translations->first();
                if ($opTranslation) {
                    $entity->operation->name = $opTranslation->name;
                }
            }

            if ($entity->relationLoaded('status') && $entity->status) {
                $statusTranslation = $entity->status->translations->first();
                if ($statusTranslation) {
                    $entity->status->name = $statusTranslation->name;
                }
            }
        }
    }

    /**
     * Aplica traducciones a una colección de entidades
     */
    private function applyTranslationsToCollection($collection, $locale)
    {
        foreach ($collection as $entity) {
            $this->applyTranslationsToSingle($entity, $locale);
        }
    }
}