<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\District;
use App\Models\PropertyTranslation;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        // Obtener propiedades con su imagen principal y tipo de propiedad
        $properties = Property::with('propertyType')->with(['firstImage'])
            ->when($request->input('sortField'), function ($query) use ($request) {
                $query->orderBy($request->input('sortField'), $request->input('sortDirection', 'asc'));
            })
            ->paginate(12);

        $propertyTypes = PropertyType::all();
        $districts = District::all();

        return view('properties.index', compact('properties', 'propertyTypes', 'districts'));
    }

    public function show($locale, $id)
    {
        // Obtener propiedad con imágenes, tipo, operación y estado
        $property = Property::with(['images', 'propertyType', 'operation', 'status'])
            ->findOrFail($id);

        // Buscar traducción en el idioma solicitado
        $translation = $property->translations()->where('locale', $locale)->first();

        if ($translation) {
            // Aplicar traducción si existe
            $property->title = $translation->title ?? $property->title;
            $property->description = $translation->description ?? $property->description;
            $property->meta_description = $translation->meta_description ?? $property->meta_description;
        }

        // Obtener 4 propiedades relacionadas con el mismo tipo
        $rel_properties = Property::with('firstImage')
            ->where('property_type_id', $property->property_type_id)
            ->where('id', '!=', $property->id)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        return view('properties.show', compact('property', 'rel_properties'));
    }
}
