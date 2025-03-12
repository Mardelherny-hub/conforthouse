<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Helpers\LibreTranslateHelper;
use App\Models\PropertyTranslation;
use App\Helpers\BreadcrumbHelper;

class AdminPropertyController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(10);

        $breadcrumbs = BreadcrumbHelper::generate([
            'Escritorio' => route('admin.dashboard'),
            'Propiedades' => route('admin.properties.index'),
            'Sección Actual' => null
        ]);

        return view('admin.properties.index', compact('properties', 'breadcrumbs'));
    }

    public function create()
    {
        return view('admin.properties.create');
    }

    public function store(Request $request)
    {
        $property = Property::create($request->all());

        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

        foreach ($languages as $lang) {
            PropertyTranslation::create([
                'property_id' => $property->id,
                'locale' => $lang,
                'operation' => LibreTranslateHelper::translate($request->operation, 'es', $lang),
                'property_type' => LibreTranslateHelper::translate($request->property_type, 'es', $lang),
                'condition' => LibreTranslateHelper::translate($request->condition, 'es', $lang),
                'orientation' => LibreTranslateHelper::translate($request->orientation, 'es', $lang),
                'exterior_type' => LibreTranslateHelper::translate($request->exterior_type, 'es', $lang),
                'kitchen_type' => LibreTranslateHelper::translate($request->kitchen_type, 'es', $lang),
                'heating_type' => LibreTranslateHelper::translate($request->heating_type, 'es', $lang),
                'interior_carpentry' => LibreTranslateHelper::translate($request->interior_carpentry, 'es', $lang),
                'exterior_carpentry' => LibreTranslateHelper::translate($request->exterior_carpentry, 'es', $lang),
                'flooring_type' => LibreTranslateHelper::translate($request->flooring_type, 'es', $lang),
                'views' => LibreTranslateHelper::translate($request->views, 'es', $lang),
                'regime' => LibreTranslateHelper::translate($request->regime, 'es', $lang),
                'description' => LibreTranslateHelper::translate($request->description, 'es', $lang),
            ]);
        }

        return redirect()->route('admin.properties.index')->with('success', 'Propiedad creada con traducciones');
    }

    public function edit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        $property->update($validated);

        return redirect()->route('admin.properties.index');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index');
    }
}
