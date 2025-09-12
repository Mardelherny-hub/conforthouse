<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Operation;
use App\Models\District;
use App\Models\PropertyTranslation;
use Illuminate\Http\Request;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $operationId = $request->query('operation_id');
        $typeId = $request->query('type_id');
        $max_price = $request->query('max_price');
        $min_price = $request->query('min_price');
        $search = $request->query('search'); // Añadido para manejar búsquedas por texto

        // Consulta base con relaciones necesarias
        $query = Property::with([
            'images', 
            'propertyType', 
            'operation', 
            'status',
            'descriptions' => function($q) use ($locale) {
                $q->whereIn('locale', [$locale, 'es'])
                ->orderByRaw("locale = ? DESC", [$locale]);
            }
        ]);

        // Aplicar filtros si existen
        if ($operationId) {
            $query->where('operation_id', $operationId);
        }

        if ($typeId) {
            $query->where('property_type_id', $typeId);
        }

        if ($max_price && $min_price) {
            $query->whereBetween('price', [$min_price, $max_price]);
        } elseif ($max_price) {
            $query->where('price', '<=', $max_price);
        } elseif ($min_price) {
            $query->where('price', '>=', $min_price);
        }

        // Añadir búsqueda por texto
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Obtener resultados paginados
        $properties = $query->latest()->paginate(9);

        // Aplicar traducciones a cada propiedad
        foreach ($properties as $property) {
            $this->applyTranslations($property, $locale);
            //$this->translateRelations($property, $locale);
        }

        // Obtener operaciones y tipos para los filtros del formulario
        $operations = Operation::all();
        $propertyTypes = PropertyType::all();

        // Traducir las operaciones y tipos para mostrar en los filtros
        //foreach ($operations as $operation) {
        //    $this->translateRelation($operation, 'name', $locale);
        //}

        //foreach ($propertyTypes as $type) {
        //    $this->translateRelation($type, 'name', $locale);
        //}
        //dd($properties);

        return view('properties.index', compact(
            'properties',
            'operationId',
            'typeId',
            'max_price',
            'min_price',
            'operations',
            'propertyTypes',
            'search'
        ));
    }

    public function show($locale, $slug)
    {

        // Primero intentar buscar por slug en la tabla principal
        $propertyQuery = Property::with([
            'images', 
            'propertyType', 
            'operation', 
            'status',
            'descriptions' => function($q) use ($locale) {
                $q->whereIn('locale', [$locale, 'es'])
                ->orderByRaw("locale = ? DESC", [$locale]);
            }
        ]);

        // Buscar la propiedad primero por el slug en la tabla principal
        $property = $propertyQuery->where('slug', $slug)->first();


        if (!$property) {
            $propertyId = PropertyTranslation::where('slug', $slug)
                                            ->where('locale', $locale)
                                            ->value('property_id');
             if ($propertyId) {
            $property = Property::with(['images', 'propertyType', 'operation', 'status'])->where('id', $propertyId)->firstOrFail();
            }

        }
        // Aplicar traducciones a la propiedad
        $this->applyTranslations($property, $locale);

        // Traducir tipo, estado y operación
        //$this->translateRelations($property, $locale);

        // Obtener 4 propiedades relacionadas con el mismo tipo
        $rel_properties = Property::with([
                'firstImage',
                'descriptions' => function($q) use ($locale) {
                    $q->whereIn('locale', [$locale, 'es'])
                    ->orderByRaw("locale = ? DESC", [$locale]);
                }
            ])
            ->where('property_type_id', $property->property_type_id)
            ->where('id', '!=', $property->id)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        // Aplicar traducciones a las propiedades relacionadas
        foreach ($rel_properties as $rel_property) {
            $this->applyTranslations($rel_property, $locale);
            // Traducir tipo, estado y operación
            //$this->translateRelations($rel_property, $locale);
           
        }
        

        //dd($rel_properties);

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
        // DEBUG: Ver el resultado del where()
    $filtered = $property->descriptions->where('locale', $locale);
    $translation = $filtered->first();
       
        if ($translation) {
            // Solo aplicar título si existe en la traducción
            if (!empty($translation->title)) {
                $property->title = $translation->title;
            }
            // Descripción sí se aplica siempre
            $property->description = $translation->description ?? $property->description;
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
    public function services($locale)
    {
        return view('services.index', compact('locale'));
    }

    public function about($locale)
    {
        return view('about.index', compact('locale'));
    }

    public function contact($locale)
    {
        return view('contact.index', compact('locale'));
    }

    public function privacy($locale)
    {
        return view('privacy.index', compact('locale'));
    }
}
