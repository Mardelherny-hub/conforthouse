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
    
    // Filtros básicos existentes
    $operationId = $request->query('operation_id');
    $typeId = $request->query('type_id');
    $max_price = $request->query('max_price');
    $min_price = $request->query('min_price');
    $search = $request->query('search');

    // Nuevos filtros avanzados
    $bedrooms = $request->query('bedrooms');
    $bathrooms = $request->query('bathrooms');
    $keyvista = $request->query('keyvista');
    $min_area = $request->query('min_area');
    $features = $request->query('features', []);

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
    ])->select('properties.*');

    // === FILTROS BÁSICOS EXISTENTES ===
    
    // Manejo especial para Viviendas de Lujo (ID=3)
    if ($operationId == 3) {
        $query->where('precioinmo', '>=', 3000000);
    } elseif ($operationId) {
        $query->where('operation_id', $operationId);
    }

    if ($typeId) {
        $query->where('property_type_id', $typeId);
    }

    // Filtros de precio - usar precioinmo que es el campo principal
    if ($max_price && $min_price) {
        $query->whereBetween('precioinmo', [$min_price, $max_price]);
    } elseif ($max_price) {
        $query->where('precioinmo', '<=', $max_price);
    } elseif ($min_price) {
        $query->where('precioinmo', '>=', $min_price);
    }

    // Búsqueda por texto
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('zona_inmovilla', 'like', "%{$search}%")
                ->orWhere('ciudad_inmovilla', 'like', "%{$search}%")
                ->orWhere('reference', 'like', "%{$search}%");
        });
    }

    // === NUEVOS FILTROS AVANZADOS ===
    
    // Filtro por habitaciones (usando total_hab que es el campo de Inmovilla)
    if ($bedrooms) {
        $query->where('total_hab', '>=', $bedrooms);
    }

    // Filtro por baños (usando banyos que es el campo correcto)
    if ($bathrooms) {
        $query->where('bathrooms', '>=', $bathrooms);
    }

    // Filtro por vista (keyvista)
    if ($keyvista) {
        switch ($keyvista) {
            case 'sea':
                $query->where(function($q) {
                    $q->where('keyvista', 'like', '%mar%')
                      ->orWhere('keyvista', 'like', '%sea%')
                      ->orWhere('vistasalmar', true);
                });
                break;
            case 'mountain':
                $query->where(function($q) {
                    $q->where('keyvista', 'like', '%montaña%')
                      ->orWhere('keyvista', 'like', '%mountain%');
                });
                break;
            case 'golf':
                $query->where(function($q) {
                    $q->where('keyvista', 'like', '%golf%');
                });
                break;
            case 'city':
                $query->where(function($q) {
                    $q->where('keyvista', 'like', '%ciudad%')
                      ->orWhere('keyvista', 'like', '%city%');
                });
                break;
            case 'pool':
                $query->where(function($q) {
                    $q->where('keyvista', 'like', '%piscina%')
                      ->orWhere('keyvista', 'like', '%pool%');
                });
                break;
        }
    }

    // Filtro por área mínima construida
    if ($min_area) {
        $query->where('built_area', '>=', $min_area);
    }

    // Filtros por características exteriores
    if (!empty($features)) {
        foreach ($features as $feature) {
            switch ($feature) {
                case 'piscina':
                    $query->where(function($q) {
                        $q->where('piscina_com', true)
                          ->orWhere('piscina_prop', true);
                    });
                    break;
                case 'terraza':
                    $query->where('terraza', true);
                    break;
                case 'jardin':
                    $query->where('jardin', true);
                    break;
                case 'balcon':
                    $query->where('balcon', true);
                    break;
                case 'parking':
                    $query->where('parking', '>', 0);
                    break;
                case 'aire_acondicionado':
                    $query->where('aire_con', true);
                    break;
            }
        }
    }

    // === LÓGICA EXISTENTE PARA COMPLEJOS ===
    
    $showComplexes = $request->query('complexes');

    if ($showComplexes === 'true') {
        $query->whereNotNull('keypromo')->where('keypromo', '!=', 0);
    }

    // === ORDENAMIENTO ===
    $sort = $request->query('sort', 'recent'); // por defecto: más recientes

    switch ($sort) {
        case 'price_asc':
            $query->orderBy('precioinmo', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('precioinmo', 'desc');
            break;
        case 'recent':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }

    // Obtener resultados paginados
    $properties = $query->paginate(9);

    // Agrupar por complejos si se solicita
    $groupedComplexes = null;
    if ($showComplexes === 'true') {
        $groupedComplexes = $properties->groupBy('keypromo')->map(function($group) {
            $first = $group->first();
            return [
                'name' => $first->zona_inmovilla,
                'city' => $first->ciudad_inmovilla, 
                'count' => $group->count(),
                'properties' => $group
            ];
        });
    }

    // Aplicar traducciones a cada propiedad
    foreach ($properties as $property) {
        $this->applyTranslations($property, $locale);
    }

    // Obtener operaciones y tipos para los filtros del formulario
    $operations = Operation::all();
    $propertyTypes = PropertyType::all();

    
    
    // Pasar todas las variables a la vista
    return view('properties.index', compact(
        'properties',
        'groupedComplexes', 
        'showComplexes',
        'operationId',
        'typeId',
        'max_price',
        'min_price',
        'operations',
        'propertyTypes',
        'search',
        // Nuevas variables para el formulario avanzado
        'bedrooms',
        'bathrooms',
        'keyvista',
        'min_area',
        'features',
        'sort'
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
            'videos',
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

        //dd($property);
        

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

    public function legal($locale)
    {
        return view('legal.index', compact('locale'));
    }
}
