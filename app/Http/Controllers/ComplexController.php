<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class ComplexController extends Controller
{
    /**
     * Listado de todos los complejos residenciales
     */
    public function index(Request $request)
{
    $locale = app()->getLocale();
    
    // Obtener parámetros de búsqueda
    $city = $request->query('city');
    $min_price = $request->query('min_price');
    $max_price = $request->query('max_price');
    
    // Query base para complejos
    $query = Property::whereNotNull('keypromo')
        ->where('keypromo', '!=', 0)
        ->with(['images']);
    
    // Aplicar filtros
    if ($city) {
        $query->where('ciudad_inmovilla', $city);
    }
    
    if ($min_price) {
        $query->where('precioinmo', '>=', $min_price);
    }
    
    if ($max_price) {
        $query->where('precioinmo', '<=', $max_price);
    }
    
    // Obtener complejos agrupados
    $complexes = $query->get()
        ->groupBy('keypromo')
        ->map(function($group) {
            $first = $group->first();
            return [
                'keypromo' => $first->keypromo,
                'name' => $first->zona_inmovilla,
                'city' => $first->ciudad_inmovilla,
                'count' => $group->count(),
                'min_price' => $group->min('precioinmo'),
                'max_price' => $group->max('precioinmo'),
                'featured_image' => $first->images->first(),
                'sample_property' => $first
            ];
        })
        ->sortByDesc('count');

    // Obtener ciudades únicas que tienen complejos
    $cities = Property::whereNotNull('keypromo')
        ->where('keypromo', '!=', 0)
        ->distinct()
        ->pluck('ciudad_inmovilla')
        ->filter()
        ->sort()
        ->values();

    return view('complexes.index', compact('complexes', 'locale', 'cities', 'city', 'min_price', 'max_price'));
}

    /**
     * Mostrar propiedades de un complejo específico
     */
    public function show(Request $request, $locale, $keypromo)
    {
        // Obtener todas las propiedades del complejo
        $properties = Property::where('keypromo', $keypromo)
            ->with(['images', 'propertyType', 'operation', 'status'])
            ->paginate(12);

        if ($properties->isEmpty()) {
            abort(404, 'Complejo no encontrado');
        }

        $complex = [
            'keypromo' => $keypromo,
            'name' => $properties->first()->zona_inmovilla,
            'city' => $properties->first()->ciudad_inmovilla,
            'count' => $properties->total()
        ];

        return view('complexes.show', compact('properties', 'complex', 'locale'));
    }
}